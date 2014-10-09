<?php

namespace Sf\FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class BrandController extends Controller {

    /**
     * 
     * @Route("/la-marque",name="front_brand")
     * @Template()
     */
    public function indexAction() {
        $em = $this->getDoctrine()->getManager();
        $brand = $em->getRepository('SfAdminBundle:Brand')->findOneBy(array('active' => true), array('id' => 'desc'));

        return array('brand' => $brand);
    }

}
