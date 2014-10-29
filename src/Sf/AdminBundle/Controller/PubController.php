<?php

namespace Sf\AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sf\AdminBundle\Entity\Pub;
use Sf\AdminBundle\Form\PubType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class PubController extends Controller {

    /**
     * @Template()
     *
     *
     */
    public function indexAction(Request $request) {

        $em = $this->get('doctrine')->getManager();
        $entities = $em->getRepository('SfAdminBundle:Pub')->findBy(array(),array('position' => 'asc'));

       // \Doctrine\Common\Util\Debug::dump($entities); die();

        return array('entities' => $entities);
    }

    /**
     * @Template()
     *
     *
     */
    public function updateAction(Request $request, Pub $pub = null) {

        $em = $this->get('doctrine')->getManager();

        if ($pub == null){
            $pub = new Pub();
        }

        $form = $this->createForm(new PubType, $pub);

        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);
            if ($form->isValid()) {

               $pub->preUpload();
                $em->persist($pub);
                $em->flush();
                $pub->upload();
               return $this->redirect($this->generateUrl('admin_pub'));
            }
        }


        return array('form' => $form->createView());
    }

}
