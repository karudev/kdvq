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
        /*$em = $this->get('doctrine')->getManager();
        $entities = $em->getRepository('SfAdminBundle:AboutUs')->findBy(array('active' => true));

        $aboutUs = null;
        if (count($entities) > 0) {
            $aboutUs = $entities[0];
        }
        return array('aboutUs' => $aboutUs);*/
        return array();
    }

}


