<?php

namespace Sf\FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Sf\AdminBundle\Entity\Order;
use Sf\FrontBundle\Service\PaypalIpn\IpnListener;
use Sf\AdminBundle\Entity\ShoppingCart;

class TransactionController extends Controller {

    /**
     * @Route("/transaction/cancel/{token}" ,name="transaction_cancel", options = {"i18n" = false})
     * @Template()
     */
    public function cancelAction(Request $request, $token) {
        $em = $this->getDoctrine()->getManager();

        $transaction = $em->getRepository('SfAdminBundle:Transaction')->findOneBy(array('token' => $token));
        if ($transaction) {
            $transaction->setState('Cancel')
                    ->setDate(new \Datetime())
                    ->setToken(null);

            $em->persist($transaction);
            $em->flush();

            $order = $em->getRepository('SfAdminBundle:Order')->findOneBy(array('transaction' => $transaction));
            $em->remove($order);
            $em->flush();
        }
        $message = $this->container->get('translator')->trans('Votre transaction a été annulée', array(), 'SfFrontBundle');
        $this->container->get('session')->getFlashBag()->add('info', $message);

        return $this->redirect($this->generateUrl('front_shopping_cart'));
    }

    /**
     * @Route("/transaction/confirm/{token}",name="transaction_confirm", options = {"i18n" = false})
     * @Template()
     */
    public function confirmAction(Request $request, $token) {
        $em = $this->getDoctrine()->getManager();
        $transaction = $em->getRepository('SfAdminBundle:Transaction')->findOneBy(array('token' => $token));

        if (!$transaction) {
            $message = $this->container->get('translator')->trans('Cette transaction a échouée', array(), 'SfFrontBundle');
            $this->container->get('session')->getFlashBag()->add('danger', $message);
            return $this->redirect($this->generateUrl('front_shopping_cart'));
        }


        $transaction->setState('Checkout')
                ->setDate(new \Datetime())
        ;

        $em->persist($transaction);

        $em->flush();

        $message = $this->container->get('translator')->trans('Votre transaction et votre commande sont en cours de vérification, vous allez recevoir un email de confirmation', array(), 'SfFrontBundle');
        $this->container->get('session')->getFlashBag()->add('success', $message);


        $this->container->get('shoppingcart')->save($this->getUser(), $transaction);

        return $this->redirect($this->generateUrl('account'));
    }

    /**
     * @Route("/transaction/ipn",name="transaction_ipn", options = {"i18n" = false})
     * @Template()
     */
    public function ipnAction() {


        ini_set('log_errors', true);
        ini_set('error_log', dirname(__FILE__) . '/../Service/PaypalIpn/example/ipn_errors.log');


// instantiate the IpnListener class
        //include(__DIR__ .'/../Service/PaypalIpn/ipnlistener.php');  
        $listener = new IpnListener();

        $listener->force_ssl_v3 = false;

        /*
          When you are testing your IPN script you should be using a PayPal "Sandbox"
          account: https://developer.paypal.com
          When you are ready to go live change use_sandbox to false.
         */
        $listener->use_sandbox = false;

        /*
          By default the IpnListener object is going  going to post the data back to PayPal
          using cURL over a secure SSL connection. This is the recommended way to post
          the data back, however, some people may have connections problems using this
          method.

          To post over standard HTTP connection, use:
          $listener->use_ssl = false;

          To post using the fsockopen() function rather than cURL, use:
          $listener->use_curl = false;
         */

        /*
          The processIpn() method will encode the POST variables sent by PayPal and then
          POST them back to the PayPal server. An exception will be thrown if there is
          a fatal error (cannot connect, your server is not configured properly, etc.).
          Use a try/catch block to catch these fatal errors and log to the ipn_errors.log
          file we setup at the top of this file.

          The processIpn() method will send the raw data on 'php://input' to PayPal. You
          can optionally pass the data to processIpn() yourself:
          $verified = $listener->processIpn($my_post_data);
         */


        if (isset($_POST['command'])) {
            $verified = true;
        } else {
            try {
                $listener->requirePostMethod();
                $verified = $listener->processIpn();
            } catch (\Exception $e) {
                error_log($e->getMessage());
                return array();
            }
        }

        // Variables renvoyés par Paypal
        $payment_status = isset($_POST['payment_status']) ? $_POST['payment_status'] : null;
        $payment_amount = isset($_POST['mc_gross']) ? $_POST['mc_gross'] : null;
        $payment_currency = isset($_POST['mc_currency']) ? $_POST['mc_currency'] : null;
        $tax = isset($_POST['tax']) ? $_POST['tax'] : null;
        $shipping = isset($_POST['shipping']) ? $_POST['shipping'] : null;
        $paypal_email = isset($_POST['receiver_email']) ? $_POST['receiver_email'] : null;
        $token = isset($_POST['custom']) ? $_POST['custom'] : null;

        $em = $this->getDoctrine()->getManager();

        $transaction = $em->getRepository('SfAdminBundle:Transaction')->checkout(
                array(
                    'amountHt' => $payment_amount,
                    'currency' => $payment_currency,
                    'tva' => $tax,
                    'shipping' => $shipping,
                    'token' => $token,
                )
        );

       
       
       
          $message = \Swift_Message::newInstance()
                    ->setSubject('debug')
                    ->setFrom('renault@karudev.fr')
                    ->setTo('renault@karudev.fr')
                    ->setBody($payment_status.' '.$payment_amount.' '.$payment_currency.' '.$tax
                            .' '.$shipping.' '.$paypal_email.' '.$token .'bool =>'.(bool)$verified, 'text/html');
            $this->get('mailer')->send($message);

        //var_dump($paypal_email); die();
        if ($paypal_email != $this->container->getParameter('paypal_email') || $transaction == false) {
            $transaction = $em->getRepository('SfAdminBundle:Transaction')->findOneBy(array('token' => $token));

            if ($transaction) {
                $this->get('transaction')->invalid($transaction);
            }

            # Send email
            $this->get('sf_user.mail_helper')->fraud($transaction);

            return array();
        }



        /*
          The processIpn() method returned true if the IPN was "VERIFIED" and false if it
          was "INVALID".
         */
        if ($verified) {
            /*
              Once you have a verified IPN you need to do a few more checks on the POST
              fields--typically against data you stored in your database during when the
              end user made a purchase (such as in the "success" page on a web payments
              standard button). The fields PayPal recommends checking are:

              1. Check the $_POST['payment_status'] is "Completed"
              2. Check that $_POST['txn_id'] has not been previously processed
              3. Check that $_POST['receiver_email'] is your Primary PayPal email
              4. Check that $_POST['payment_amount'] and $_POST['payment_currency']
              are correct

              Since implementations on this varies, I will leave these checks out of this
              example and just send an email using the getTextReport() method to get all
              of the details about the IPN.
             */
            $this->get('transaction')->verified($transaction, $payment_status);
        } else {

            $this->get('transaction')->invalid($transaction);

            /*
              An Invalid IPN *may* be caused by a fraudulent transaction attempt. It's
              a good idea to have a developer or sys admin manually investigate any
              invalid IPN.
             */
            //print_r($listener->getTextReport());
            // die('NO');
        }



        return array();
    }

}
