<?php

namespace Sf\UserBundle\Service\Helper;

use Sf\UserBundle\Entity\User;
use Sf\AdminBundle\Entity\Order;
use Sf\AdminBundle\Entity\Transaction;

class MailHelper {

    public $container;
    public $subject = null;
    public $from = null;
    public $setTo = null;
    public $body = null;
    public $senderName = null;
    public $lang = 'fr';

    public function __construct($container, $from, $senderName) {
        $this->container = $container;
        $this->from = $from;
        $this->senderName = $senderName;
        $this->lang = $container->get('request')->getLocale();
    }

    public function activeAccount(User $user) {
        $this->setTo = $user->getEmail();
        $this->subject = $this->container->get('translator')->trans('%mailer_name% : Activation de votre compte', array('%mailer_name%' => $this->container->getParameter('mailer_name')), 'SfFrontBundle');
        //$user->setConfirmationToken(md5($user->getEmail() . time()));

        $url = $this->container->get('router')->generate('sf_user_registration_active_account', array('token' => $user->getConfirmationToken()), true);
        $this->body = $this->container->get('templating')->render('SfUserBundle:Mailing:activeAccount.html.twig', array(
            'user' => $user,
            'url' => $url
        ));
        $this->send();
    }

    public function confirmOrder(Order $order) {
        $this->setTo = $order->getAccount()->getEmail();
        $subject = $this->container->get('translator')->trans('%mailer_name% : Informations sur votre commande', array('%mailer_name%' => $this->container->getParameter('mailer_name')), 'SfFrontBundle') . ' ' . $order->getNumber();
        $this->subject = $subject;
        $this->body = $this->container->get('templating')->render('SfUserBundle:Mailing:confirmOrder.html.twig', array(
            'order' => $order,
                //'lang' => $this->lang
        ));
        $this->send();

        # Send a copie for the factory
        $factory = $this->container->get('doctrine')->getManager()->getRepository('SfAdminBundle:Config')->findOneBy(array('type' => 'factory_email'));
        if ($factory) {
            $this->subject = '(Copie) ' . $this->subject;
            $this->setTo = $factory->getValue();
            $this->send(false);
        }

       // $typeReceiver = $order->getAccount()->hasRole('ROLE_SHOP') ? 'shop' : 'customer';
        //$this->container->get('mail')->insert($order, $subject, $this->body, 'admin', null, $order->getAccount(), null, 'admin', $typeReceiver);
    }

    public function changeOrder(Order $order) {
        $this->setTo = $order->getAccount()->getEmail();
        $subject = $this->container->get('translator')->trans('%mailer_name% : Informations sur votre commande', array('%mailer_name%' => $this->container->getParameter('mailer_name')), 'SfFrontBundle') . ' ' . $order->getNumber();
        $this->subject = $subject;
        $this->body = $this->container->get('templating')->render('SfUserBundle:Mailing:changeOrder.html.twig', array(
            'order' => $order,
            'coliposteUrl' => $this->container->getParameter('colisposte_url'),
                //'lang' => $this->lang
        ));
        $this->send();
       // $typeReceiver = $order->getAccount()->hasRole('ROLE_SHOP') ? 'shop' : 'customer';
       // $this->container->get('mail')->insert($order, $subject, $this->body, 'admin', null, $order->getAccount(), null, 'admin', $typeReceiver);
    }

    public function fraud(Transaction $transaction = null) {
        $m = $transaction == null ? null : ' #' . $transaction->getId();
        $this->subject = $this->container->get('translator')->trans('%mailer_name% : Informations sur la transaction', array('%mailer_name%' => $this->container->getParameter('mailer_name')), 'SfFrontBundle') . $m;
        $this->body = $this->container->get('templating')->render('SfUserBundle:Mailing:fraud.html.twig', array(
            'transaction' => $transaction
        ));
        $this->send();
    }

    public function custom($subject, $text, $from, $senderName, $to) {
        $this->subject = $subject;
        $this->body = $text;
        $this->setTo = $to;
        $this->setFrom = $from;
        $this->senderName = $senderName;
        $this->send(false);
    }

    /**
     * Send email
     */
    public function send($copie = true) {

        if ($this->setTo != null) {
            $message = \Swift_Message::newInstance()
                    ->setSubject($this->subject)
                    ->setFrom($this->from, $this->senderName)
                    ->setTo($this->setTo)
                    ->setBody($this->body, 'text/html');
            $this->container->get('mailer')->send($message);
        }
        if ($copie) {
            # Send a copie
            $this->subject = '(Copie) ' . $this->subject;
            $this->setTo = $this->from;
            $this->send(false);
        }
    }

}
