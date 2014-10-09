<?php

namespace Sf\AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sf\AdminBundle\Entity\LastCatalog;
use Sf\AdminBundle\Form\LastCatalogType;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class CatalogController extends Controller {

    
      /**
     * @Template()
     *
     *
     */
    public function indexAction(Request $request) {
        return array();
    }
   
    /**
     * @Template()
     *
     *
     */
    public function clubAction(Request $request) {

        $em = $this->get('doctrine')->getManager();

        $lastCatalogClub = $em->getRepository('SfAdminBundle:LastCatalog')->findOneBy(array('type' => 'club'),array('id' =>'desc'));
        if (!$lastCatalogClub ){
            $lastCatalogClub = new LastCatalog();
        }
        
        $lastCatalogClub->setType('club');
        $form = $this->createForm(new LastCatalogType, $lastCatalogClub,array('action' => $this->generateUrl('admin_catalog_club')));
        
       
       

        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);
           
            if ($form->isValid()) {
                
               
                $lastCatalogClub->preUpload();
                $em->persist($lastCatalogClub);
              
                $lastCatalogClub->upload();
                  $em->flush();
                
            }
            
          
             return $this->redirect($this->generateUrl('admin_catalog'));
        }


        return array('form' => $form->createView());
    }
    
    /**
     * @Template()
     *
     *
     */
    public function pressAction(Request $request) {

        $em = $this->get('doctrine')->getManager();

        
        $lastCatalogPress = $em->getRepository('SfAdminBundle:LastCatalog')->findOneBy(array('type' => 'press'),array('id' =>'desc'));
        if (!$lastCatalogPress ){
            $lastCatalogPress = new LastCatalog();
        }
        
        $lastCatalogPress->setType('press');
        $form = $this->createForm(new LastCatalogType, $lastCatalogPress,array('action' => $this->generateUrl('admin_catalog_press')));

        if ($request->getMethod() == 'POST') {
        
            $form->handleRequest($request);
          
            if ($form->isValid()) {
                $lastCatalogPress->preUpload();
                $em->persist($lastCatalogPress);
                
                $lastCatalogPress->upload();
                $em->flush();
              
            }
            
             return $this->redirect($this->generateUrl('admin_catalog'));
        }


        return array('form' => $form->createView());
    }

   
}
