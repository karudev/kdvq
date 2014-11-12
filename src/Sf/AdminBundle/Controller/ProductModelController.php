<?php

namespace Sf\AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sf\AdminBundle\Entity\Product;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sf\AdminBundle\Entity\ProductModel;
use Symfony\Component\Filesystem\Filesystem;
use Sf\AdminBundle\Form\ProductModelType;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * ProductModel controller.
 *
 */
class ProductModelController extends Controller {

    /**
     * @Template()
     * Lists all ProductModel entities.
     *
     */
    public function indexAction(Product $product) {
       
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('SfAdminBundle:ProductModel')->getProductModelsGroupByRef(null, $product);

        //  print_r($entities); die();
        return array('entities' => $entities, 'product' => $product);
    }

    /**
     * @Template()
     * Manage a productModel entity.
     *
     */
    public function updateAction(Request $request, $number) {

        
        $em = $this->getDoctrine()->getManager();
        $productModel = $em->getRepository('SfAdminBundle:ProductModel')->findOneBy(array('number' => $number,'deleted' => false, 'order' => null));
        $form = $this->createForm(new ProductModelType, $productModel);

        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $productModel->setNumber();


                $em->persist($productModel);

                $productModels = $em->getRepository('SfAdminBundle:ProductModel')->findBy(array('number' => $number,'deleted' => false, 'order' => null));
                foreach ($productModels as $key => $value) {
                    $value->setSize($productModel->getSize())
                            ->setColor($productModel->getColor())
                            ->setMaterial($productModel->getMaterial())
                            ->setNumberEntity($productModel->getNumberEntity())
                            ->setNumber();
                    $em->persist($value);
                }

                $em->flush();
            }
            return $this->redirect($this->generateUrl('admin_product_model', array('product' => $productModel->getProduct()->getId())));
        }
        return array('form' => $form->createView(), 'productModel' => $productModel);
    }

    /**
     * @Template()
     * Manage a stock.
     *
     */
    public function stockAction(Request $request, Product $product = null) {

        ini_set('max_execution_time', -1);
        $em = $this->getDoctrine()->getManager();

        $productModel = new ProductModel();


        
        if ($product != null) {
            $productModel->setProduct($product);
        }
        $form = $this->createForm(new ProductModelType(), $productModel,
                array('action' => $this->generateUrl('admin_product_model_stock',array('product' =>$product->getId() ))));


        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $quantity = $request->get('quantity');
                for ($i = 0; $i < $quantity; $i++) {
                   $productModel->setNumber();
                    $pm = clone $productModel;
                 
                    $em->persist($pm);
                    $em->flush();
                }
            }
              // \Doctrine\Common\Util\Debug::dump($productModel); die();
            return $this->redirect($this->generateUrl('admin_product_model', array('product' => $productModel->getProduct()->getId())));
        }


        return array(
            'form' => $form->createView(),
            'product' => $product
        );
    }

    /**
     * Delete a ProductModels entities.
     *
     */
    public function deleteAction(Request $request) {
        $number = $request->get('number');
        $quantity = $request->get('quantity');
        $productId = $request->get('productId');
        $em = $this->getDoctrine()->getManager();
        if ($quantity > 0) {


            $m = $em->getRepository('SfAdminBundle:ProductModel')->findBy(
                    array('number' => $number,'deleted' => false,'order' => null), array(), $quantity
            );

          
            foreach ($m as $value) {
                $value->setDeleted(true);
                $value->setDeletedAt(new \DateTime);
                $em->persist($value);
            }
            $em->flush();


        } 

        return new JsonResponse(array('productId' => $productId));
    }

}
