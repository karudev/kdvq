<?php

namespace Sf\AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Sf\AdminBundle\Entity\Actuality;
use Sf\AdminBundle\Form\ActualityType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class ActualityController extends Controller {

    /**
     * @Template()
     *
     *
     */
    public function indexAction(Request $request) {

        $em = $this->get('doctrine')->getManager();
       
        $actualities = $em->getRepository('SfAdminBundle:Actuality')->findBy(array(),array('date' => 'desc'));


        return array('actualities' => $actualities);
    }

  

     /**
     * @Template()
     *
     *
     */
    public function updateAction(Request $request, Actuality $actuality = null) {

        $em = $this->get('doctrine')->getManager();

        if ($actuality == null){
            $actuality = new Actuality();
        }

        $form = $this->createForm(new ActualityType, $actuality);

        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);
            if ($form->isValid()) {

                $actuality->setYear(date('Y',$actuality->getDate()->getTimestamp()));
                $actuality->setMonth(date('Ym',$actuality->getDate()->getTimestamp()));
                $actuality->preUpload();
                $em->persist($actuality);
                $actuality->upload();
                $em->flush();
               return $this->redirect($this->generateUrl('admin_actuality'));
            }
        }


        return array('form' => $form->createView());
    }
}
