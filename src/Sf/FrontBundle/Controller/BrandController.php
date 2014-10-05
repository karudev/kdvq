<?php

namespace Sf\FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class BrandController extends Controller
{

    
    /**
     * 
     * @Route("/la-marque",name="front_brand")
     * @Template()
     */
    public function indexAction()
    {
        return array();
    }
    
    

}
