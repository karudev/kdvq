<?php

namespace Sf\AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sf\AdminBundle\Entity\Partner;
use Sf\AdminBundle\Form\PartnerType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class PartnerController extends Controller {

    /**
     * @Template()
     *
     *
     */
    public function indexAction(Request $request) {

        $em = $this->get('doctrine')->getManager();
        $entities = $em->getRepository('SfAdminBundle:Partner')->findBy(array('active' => true), array('id' => 'desc'));



        return array('entities' => $entities);
    }

    /**
     * @Template()
     *
     *
     */
    public function updateAction(Request $request, Partner $partner = null) {

        $em = $this->get('doctrine')->getManager();

        if ($partner == null){
            $partner = new Partner();
        }

        $form = $this->createForm(new PartnerType, $partner);

        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);
            if ($form->isValid()) {

               $partner->preUpload();
                $em->persist($partner);
                $em->flush();
                $partner->upload();
               return $this->redirect($this->generateUrl('admin_partner'));
            }
        }


        return array('form' => $form->createView());
    }

}
