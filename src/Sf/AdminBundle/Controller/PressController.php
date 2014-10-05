<?php

namespace Sf\AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sf\AdminBundle\Entity\Press;
use Sf\AdminBundle\Form\PressType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class PressController extends Controller {

    /**
     * @Template()
     *
     *
     */
    public function indexAction(Request $request) {

        $em = $this->get('doctrine')->getManager();
        $entities = $em->getRepository('SfAdminBundle:Press')->findBy(array('active' => true), array('updatedAt' => 'desc'));



        return array('entities' => $entities);
    }

    /**
     * @Template()
     *
     *
     */
    public function updateAction(Request $request, Press $press = null) {

        $em = $this->get('doctrine')->getManager();

        if ($press == null){
            $press = new Press();
        }

        $form = $this->createForm(new PressType, $press);

        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);
            if ($form->isValid()) {

               $press->preUpload();
                $em->persist($press);
                $em->flush();
                $press->upload();
               return $this->redirect($this->generateUrl('admin_press'));
            }
        }


        return array('form' => $form->createView());
    }

}
