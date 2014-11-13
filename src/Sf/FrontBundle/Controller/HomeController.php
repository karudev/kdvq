<?php

namespace Sf\FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

class HomeController extends Controller {

    /**
     *
     * @Route("/",name="front_home")
     * @Template()
     */
    public function indexAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $carrousel = $em->getRepository('SfAdminBundle:Carrousel')->findBy(array('active'=>true),array('position' => 'asc'));
        $home_title = $em->getRepository('SfAdminBundle:Config')->findOneBy(array('name' => 'home_title'));
        $home_text = $em->getRepository('SfAdminBundle:Config')->findOneBy(array('name' => 'home_text'));
        $products = $em->getRepository('SfAdminBundle:Product')->findBy(array('inHome' => true,'deleted' => false, 'active' => true), array('updatedAt' => 'desc'), 3);
        $actualities = $em->getRepository('SfAdminBundle:Actuality')->findBy(
                array('active' => true,'inHome' => true), array('date' => 'desc'), 2);


        if ($request->getMethod() == 'POST') {
            $firstname = $request->get('firstname', null);
            $lastname = $request->get('lastname', null);
            $email = $request->get('email', null);

            $errors = array();

            if ($lastname == null) {

                $eMessage =  'Le nom est obligatoire';
                $errors[] = $eMessage;
                 $this->get('session')->getFlashBag()->add('danger', $eMessage);
            }
            if ($firstname == null) {

               
                $eMessage =  'Le prénom est obligatoire';
                $errors[] = $eMessage;
                 $this->get('session')->getFlashBag()->add('danger', $eMessage);
            }

            if ($email == null) {

                
                $eMessage =  'L\'émail est obligatoire';
                $errors[] = $eMessage;
                 $this->get('session')->getFlashBag()->add('danger', $eMessage);
            }
            if (count($errors) == 0) {
                $html = "";

                $html .='Nom : ' . $firstname . ' ' . $lastname . '<br/>';
                $html .='Email : ' . $email . '<br/>';
                $html .='---------------------------------------<br/>';


                $msg = \Swift_Message::newInstance()
                        ->setSubject('Qwinsport - Inscription à la Newsletter')
                        ->setFrom($email, $firstname . ' ' . $lastname)
                        ->setTo($this->container->getParameter('mailer_admin'))
                        ->setBody(nl2br($html), 'text/html');
                $this->get('mailer')->send($msg);

                $this->get('session')->getFlashBag()->add('success', 'Votre demande d\'inscription à la newsletter a été envoyé');
            }
        }
        return array('carrousel' => $carrousel, 'products' => $products, 'actualities' => $actualities,'home_title' => $home_title,'home_text' => $home_text);
    }

}

?>
