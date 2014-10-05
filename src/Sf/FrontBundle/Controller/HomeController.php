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
    public function indexAction() {
        $em = $this->getDoctrine()->getManager();

        $products = $em->getRepository('SfAdminBundle:Product')->findBy(array('deleted' => false,'active' => true),array('id' => 'desc'),3);
        
        return array('products' => $products);
       
    }

}

?>
