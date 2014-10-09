<?php

namespace Sf\FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class ContactController extends Controller {

    /**
     * 
     * @Route("/contact",name="front_contact")
     * @Template()
     */
    public function indexAction(Request $request) {

        $errors = array();
        $success = false;


        if ($request->getMethod() == 'POST') {
            $firstname = $request->get('firstname', null);
            $lastname = $request->get('lastname', null);
            $phone = $request->get('phone', null);
            $company = $request->get('company', null);
            $email = $request->get('email', null);
            $objet = $request->get('subject', null);
            $message = $request->get('message', null);


            if ($lastname == null) {
                $eMessage = $this->get('translator')->trans('Le nom est obligatoire', array(), 'SfFrontBundle');
                $this->get('session')->getFlashBag()->add('danger', $eMessage);
                $errors[] = $eMessage;
                
            }
           
            if ($objet == null) {
                $eMessage = $this->get('translator')->trans('Le sujet est obligatoire', array(), 'SfFrontBundle');
                $this->get('session')->getFlashBag()->add('danger', $eMessage);
                $errors[] = $eMessage;
            }
            if ($phone == null) {
                $eMessage = $this->get('translator')->trans('Le téléphone est obligatoire', array(), 'SfFrontBundle');
                $this->get('session')->getFlashBag()->add('danger', $eMessage);
                $errors[] = $eMessage;
            }

            if ($email == null) {
                $eMessage = $this->get('translator')->trans('L\'email est obligatoire', array(), 'SfFrontBundle');
                $this->get('session')->getFlashBag()->add('danger', $eMessage);
                $errors[] = $eMessage;
            }
            if ($message == null) {
                $eMessage = $this->get('translator')->trans('Le message est obligatoire', array(), 'SfFrontBundle');
                $this->get('session')->getFlashBag()->add('danger', $eMessage);
                $errors[] = $eMessage;
            }

            
              
            if (count($errors) == 0) {
                $html = "";

                $html .='Nom : ' . $firstname . ' ' . $lastname . '<br/>';
                $html .='Société : ' . $company . '<br/>';
                $html .='Téléphone : ' . $phone . '<br/>';
                $html .='Email : ' . $email . '<br/>';
                $html .='---------------------------------------<br/>';
                $html .= $message . '<br/>';

                $msg = \Swift_Message::newInstance()
                        ->setSubject('Qwinsport - Contact | '.$objet)
                        ->setFrom($email, $firstname . ' ' . $lastname)
                        ->setTo($this->container->getParameter('mailer_admin'))
                        ->setBody(nl2br($html), 'text/html');
                $this->get('mailer')->send($msg);
                 $success = $this->get('translator')->trans('Votre email a été envoyé', array(), 'SfFrontBundle');
                 $this->get('session')->getFlashBag()->add('success', $success);
            }
        }

        return array();
    }

}
