<?php

namespace Sf\FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class PartnerController extends Controller {

    /**
     *
     * @Route("/partenaires-et-clubs",name="front_partners")
     * @Template()
     */
    public function indexAction() {
        $em = $this->get('doctrine')->getManager();
        

        $clubs = $em->getRepository("SfAdminBundle:Partner")->findBy(array('active' => true,'type'=>'club'),array('id'=>'desc'));
        $partners = $em->getRepository("SfAdminBundle:Partner")->findBy(array('active' => true,'type'=>'partner'),array('id'=>'desc'));
        $catalog = $em->getRepository("SfAdminBundle:LastCatalog")->findOneBy(array('type' => 'club'),array('id'=>'desc'));
        
        
        return array('catalog' => $catalog,'clubs' => $clubs, 'partners' => $partners);
    }

}


