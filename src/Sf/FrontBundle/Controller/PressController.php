<?php

namespace Sf\FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class PressController extends Controller {

    /**
     *
     * @Route("/presse",name="front_press")
     * @Template()
     */
    public function indexAction() {
        $em = $this->get('doctrine')->getManager();
        
        $entities = $em->getRepository('SfAdminBundle:Press')->findBy(array('active' => true),array('updatedAt' => 'desc'));

        $catalog = $em->getRepository("SfAdminBundle:LastCatalog")->findOneBy(array('type' => 'press'),array('id'=>'desc'));
        
        
        return array( 'entities' => $entities,'catalog' => $catalog);
        
    }

}


