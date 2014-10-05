<?php

namespace Sf\FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class ActualityController extends Controller {

    /**
     *
     * @Route("/actus",name="front_actus")
     * @Template()
     */
    public function indexAction() {
        /* $em = $this->get('doctrine')->getManager();
         $dates = $em->getRepository('SfAdminBundle:Actuality')->getDates();
    
        return array('dates' => $dates);*/
        return array();
    }
    
     /**
     *
     * 
     * @Template()
     */
    public function showAction(Request $request, $year = null) {
        
        if($year == null){
            $year = date('Y');
        }
        $em = $this->get('doctrine')->getManager();
        
        $actualities = $em->getRepository('SfAdminBundle:Actuality')->findBy(
                array('year' => $year,'active' => true), array('date' => 'desc'));

     
    
        return array('actualities' => $actualities);
    }

}
