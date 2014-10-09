<?php

namespace Sf\FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class CategoryController extends Controller
{

     /**
     *
     * @Route("/catégorie/{slug}",name="front_category")
     * @Template()
     */
    public function indexAction($slug) {
        $em = $this->getDoctrine()->getManager();
        $catalog = $em->getRepository("SfAdminBundle:LastCatalog")->findOneBy(array('type' => 'club'),array('id'=>'desc'));
        return array('categorie' => $slug,'catalog'=>$catalog);
    }

}
