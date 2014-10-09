<?php

namespace Sf\FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class LegalController extends Controller
{

     /**
     *
     * @Route("/mentions-légales",name="front_legals")
     * @Template()
     */
    public function indexAction() {
        $em = $this->get('doctrine')->getManager();
        $entity = $em->getRepository('SfAdminBundle:Legal')->findOneBy(array('active' => true),array('id' => 'desc'));

        return array('entity' => $entity);
    }

}
