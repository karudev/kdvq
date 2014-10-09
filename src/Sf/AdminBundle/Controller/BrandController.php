<?php

namespace Sf\AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sf\AdminBundle\Entity\Brand;
use Sf\AdminBundle\Form\BrandType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class BrandController extends Controller {

    /**
     * @Template()
     *
     *
     */
    public function indexAction(Request $request) {

        $em = $this->get('doctrine')->getManager();

        $brand = $em->getRepository('SfAdminBundle:Brand')->findOneBy(array('active' => true), array('id' => 'desc'));
        if (!$brand) {
            $brand = new Brand();
        }



        $form = $this->createForm(new BrandType, $brand);




        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);

            if ($form->isValid()) {


                $brand->preUpload();
                $em->persist($brand);

                $brand->upload();
                $em->flush();
            }


            return $this->redirect($this->generateUrl('admin_brand'));
        }


        return array('form' => $form->createView());
    }

}
