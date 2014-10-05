<?php

namespace Sf\AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sf\AdminBundle\Form\MailType;
use Sf\AdminBundle\Entity\Mail;
use Sf\AdminBundle\Entity\Order;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Mail controller.
 *
 */
class MailController extends Controller {

    /**
     * @Template()
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param \Sf\AdminBundle\Entity\Order $order
     * @return \Sf\AdminBundle\Controller\JsonResponse
     */
    public function updateAction(Request $request, Order $order,$number = 0) {

        $mail = new Mail;
        $mail->setOrder($order);
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(new MailType(), $mail, array(
            'action' => $this->generateUrl('mail_update', array('number' =>$number,'order' => $order->getId()))
        ));

        $brands = $em->getRepository('SfAdminBundle:OrderBrand')->getBrands($order);

        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);
            if ($form->isValid()) {
                
                $sendEmail = (bool)$request->get('sendEmail', false);
               
                $ad = $em->getRepository('SfUserBundle:User')->findOneByRole('ROLE_ADMIN');
                $admin = $ad->getId().'-A';
                $user = $this->getUser()->getId().'-'.($this->getUser()->hasRole('ROLE_SHOP') ? 'S':'C');
                        
                $to = explode('-',$request->get('to',$admin));
                $from = explode('-',$request->get('from',$user));
                
               
                $senderBrand = null;
                $senderUser = null;
                $receiverBrand = null;
                $receiverUser = null;
                if ($from[1] == 'A' || $from[1] == 'C') {

                    $senderUser = $em->getRepository('SfUserBundle:User')->find($from[0]);
                    $type = $from[1] == 'A' ? 'admin' : 'customer';
                    $fromMail = $senderUser->getEmail();
                    $senderName = $senderUser->getLabel();
                    
                } elseif ($from[1] == 'B') {
                    $senderBrand = $em->getRepository('SfAdminBundle:Brand')->find($from[0]);
                    $type = 'brand';
                    $fromMail = $senderBrand->getEmail();
                    $senderName = $senderBrand->getName();
                }
                
                if ($to[1] == 'A' || $to[1] == 'C') {

                    $receiverUser = $em->getRepository('SfUserBundle:User')->find($to[0]);
                    $typeReceiver = $to[1] == 'A' ? 'admin' : 'customer';
                    $toEmail = $receiverUser->getEmail();
                } elseif ($to[1] == 'B') {
                    $receiverBrand = $em->getRepository('SfAdminBundle:Brand')->find($to[0]);
                    $typeReceiver = 'brand';
                    $toEmail = $receiverBrand->getEmail();
                }

                $mail->setSendAt(new \DateTime)
                        ->setSenderUser($senderUser)
                        ->setReceiverUser($receiverUser)
                        ->setReceiverBrand($receiverBrand)
                        ->setSenderBrand($senderBrand)
                        ->setType($type)
                        ->setTypeReceiver($typeReceiver);
                
                if($sendEmail){
                    $this->container->get('sf_user.mail_helper')->custom($mail->getSubject(),$mail->getText(),$fromMail,$senderName,$toEmail);
                }
              
                $em->persist($mail);
                $em->flush();

                

                return new JsonResponse(array(
                    'html' => $this->forward('SfAdminBundle:Order:orders',array('number' =>$number))->getContent(),
                    'success' => true
                        )
                );
            }
        }


        return array('brands' => $brands, 'form' => $form->createView());
    }

}
