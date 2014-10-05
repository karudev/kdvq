<?php

namespace Sf\AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sf\AdminBundle\Entity\Legal;
use Sf\AdminBundle\Form\LegalType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class LegalController extends Controller {

    /**
     * @Template()
     *
     *
     */
    public function indexAction(Request $request) {

        $em = $this->get('doctrine')->getManager();
        $entities = $em->getRepository('SfAdminBundle:Legal')->findAll();

        if (count($entities) > 0) {
            $legal = $entities[0];
        } else {
            $legal = new Legal;
        }
        $form = $this->createForm(new LegalType, $legal);
        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);
            if ($form->isValid()) {

               
                $em->persist($legal);
                $em->flush();
                //  $form = $this->createForm(new AboutUsType, $aboutUs);
            }
        }


        return array('form' => $form->createView());
    }

}
