<?php

namespace Sf\FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class LegalController extends Controller
{

     /**
     *
     * @Route("/legals",name="front_legals")
     * @Template()
     */
    public function indexAction() {
        $em = $this->get('doctrine')->getManager();
        $entities = $em->getRepository('SfAdminBundle:Legal')->findBy(array('active' => true));

        $entity = null;
        if (count($entities) > 0) {
            $entity = $entities[0];
        }
        return array('entity' => $entity);
    }

}
