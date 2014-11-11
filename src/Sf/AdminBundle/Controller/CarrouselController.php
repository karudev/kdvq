<?php

namespace Sf\AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sf\AdminBundle\Entity\Carrousel;
use Sf\AdminBundle\Form\CarrouselType;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class CarrouselController extends Controller {

    /**
     * @Template()
     *
     *
     */
    public function indexAction(Request $request) {

        $em = $this->get('doctrine')->getManager();
        $entities = $em->getRepository('SfAdminBundle:Carrousel')->findBy(array(),array('position' => 'asc'));

       // \Doctrine\Common\Util\Debug::dump($entities); die();

        return array('entities' => $entities);
    }

    /**
     * @Template()
     *
     *
     */
    public function updateAction(Request $request, Carrousel $carrousel = null) {

        $em = $this->get('doctrine')->getManager();

        if ($carrousel == null){
            $carrousel = new Carrousel();
        }

        $form = $this->createForm(new CarrouselType, $carrousel);

        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);
            if ($form->isValid()) {

                $carrousel->preUpload();
                $em->persist($carrousel);
                $em->flush();
                $carrousel->upload();
               return $this->redirect($this->generateUrl('admin_carrousel'));
            }
        }


        return array('form' => $form->createView());
    }

}
