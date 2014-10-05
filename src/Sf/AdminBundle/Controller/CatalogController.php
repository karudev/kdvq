<?php

namespace Sf\AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sf\AdminBundle\Entity\LastCatalog;
use Sf\AdminBundle\Form\LastCatalogType;
use Sf\AdminBundle\Entity\Catalog;
use Sf\AdminBundle\Form\CatalogType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class CatalogController extends Controller {

    /**
     * @Template()
     *
     *
     */
    public function indexAction(Request $request) {

        $em = $this->get('doctrine')->getManager();
        $lastCatalog = $em->getRepository('SfAdminBundle:LastCatalog')->findOneBy(array());
        $catalogs = $em->getRepository('SfAdminBundle:Catalog')->findBy(array(),array('id' => 'desc'));


        return array('lastCatalog' => $lastCatalog,'catalogs' => $catalogs);
    }

    /**
     * @Template()
     *
     *
     */
    public function lastAction(Request $request, LastCatalog $lastCatalog = null) {

        $em = $this->get('doctrine')->getManager();

        if ($lastCatalog == null){
            $lastCatalog = new LastCatalog();
        }

        $form = $this->createForm(new LastCatalogType, $lastCatalog);

        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);
            if ($form->isValid()) {

               
                $em->persist($lastCatalog);
                $em->flush();
               return $this->redirect($this->generateUrl('admin_catalog'));
            }
        }


        return array('form' => $form->createView());
    }

     /**
     * @Template()
     *
     *
     */
    public function updateAction(Request $request, Catalog $catalog = null) {

        $em = $this->get('doctrine')->getManager();

        if ($catalog == null){
            $catalog = new Catalog();
        }

        $form = $this->createForm(new CatalogType, $catalog);

        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);
            if ($form->isValid()) {

               
                $em->persist($catalog);
                $em->flush();
               return $this->redirect($this->generateUrl('admin_catalog'));
            }
        }


        return array('form' => $form->createView());
    }
}
