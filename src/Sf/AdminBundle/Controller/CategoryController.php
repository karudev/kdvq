<?php

namespace Sf\AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sf\AdminBundle\Entity\Category;
use Sf\AdminBundle\Form\CategoryType;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class CategoryController extends Controller {

    /**
     * @Template()
     *
     *
     */
    public function indexAction(Request $request) {

        $em = $this->get('doctrine')->getManager();
        $entities = $em->getRepository('SfAdminBundle:Category')->findBy(array(),array('category' => 'asc'));

       // \Doctrine\Common\Util\Debug::dump($entities); die();

        return array('entities' => $entities);
    }

    /**
     * @Template()
     *
     *
     */
    public function updateAction(Request $request, Category $cat = null) {

        $em = $this->get('doctrine')->getManager();

        if ($cat == null){
            $category = new Category();
        }else{
            $category = $cat;
        }

       // \Doctrine\Common\Util\Debug::dump($category);die();
        $form = $this->createForm(new CategoryType, $category);

        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);
            if ($form->isValid()) {

                if($category->getCategory()){
                $category->setMostLowLevel(true);
                }else{
                   $category->setMostLowLevel(false); 
                }
               $category->preUpload();
                $em->persist($category);
                $em->flush();
                $category->upload();
               return $this->redirect($this->generateUrl('admin_category'));
            }
        }


        return array('form' => $form->createView());
    }

}
