<?php

namespace Sf\AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sf\AdminBundle\Entity\AboutUs;
use Sf\AdminBundle\Form\AboutUsType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class AboutUsController extends Controller {

    /**
     * @Template()
     *
     *
     */
    public function indexAction(Request $request) {

        $em = $this->get('doctrine')->getManager();
        $entities = $em->getRepository('SfAdminBundle:AboutUs')->findAll();

        if (count($entities) > 0) {
            $aboutUs = $entities[0];
        } else {
            $aboutUs = new AboutUs;
        }
        $form = $this->createForm(new AboutUsType, $aboutUs);
        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);
            if ($form->isValid()) {

                if ($aboutUs->getPicture() != null) {
                  //  $aboutUs->removeUpload();
                    //$aboutUs->preUpload();
                    $aboutUs->upload();
                }
                $em->persist($aboutUs);
                $em->flush();
                //  $form = $this->createForm(new AboutUsType, $aboutUs);
            }
        }


        return array('form' => $form->createView());
    }

}
