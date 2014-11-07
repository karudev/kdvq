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
         $em = $this->get('doctrine')->getManager();
         $dates = $em->getRepository('SfAdminBundle:Actuality')->getDates();
    
        return array('dates' => $dates);
      
    }
    
     /**
     *
     *  @Route("/actus/show/{year}/{month}",name="front_actus_show", options = {"expose" = true})
     * @Template()
     */
    public function showAction(Request $request, $year = null,$month = null) {
        
        if($year == null){
            $year = date('Y');
        }
        $params = array('year' => $year,'active' => true);
        
        if($month != null){
            $params = array_merge($params, array('month' => $month));
        }
        
        $em = $this->get('doctrine')->getManager();
        
        $actualities = $em->getRepository('SfAdminBundle:Actuality')->findBy($params, array('date' => 'desc'));

     
    
        return array('actualities' => $actualities);
    }

}
