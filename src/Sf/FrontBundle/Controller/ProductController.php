<?php

namespace Sf\FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Sf\AdminBundle\Entity\Product;
use Symfony\Component\HttpFoundation\JsonResponse;

class ProductController extends Controller {

    /**
     * 
     * @Route("/produits/{categorySlug}",name="front_products")
     * @Template()
     */
    public function indexAction(Request $request, $categorySlug) {
        

        $em = $this->getDoctrine()->getManager();
       
        $filterPrice = $request->get('filterPrice',0);
        $orderPrice = $request->get('orderPrice',0);
        
        
      
        $products_intro = $em->getRepository('SfAdminBundle:Config')->findOneBy(array('name' => 'products_intro'));
        $category = $em->getRepository('SfAdminBundle:Category')->findOneBySlug($categorySlug);
        
        $products = $em->getRepository('SfAdminBundle:Product')->get($category,$filterPrice,$orderPrice);
        
         $pubs = $em->getRepository('SfAdminBundle:Pub')->findBy(array('active' => true),array('position' => 'asc'));

         
        
        return array('pubs' => $pubs,'orderPrice' => $orderPrice,'filterPrice' => $filterPrice,'products' => $products, 'category' => $category,'intro' =>  $products_intro
        );
    }

    /**
     * 
     * @Route("/produit/{slug}",name="front_product")
     * @Template()
     */
    public function productAction($slug) {

        $em = $this->getDoctrine()->getManager();
        $product = $em->getRepository('SfAdminBundle:Product')->findOneBySlug($slug);

        $parentCategory = $product->getCategory()->getCategory();

        $total = $em->getRepository('SfAdminBundle:Product')->countByParentCategory($parentCategory,$product);

        $moreProducts = $em->getRepository('SfAdminBundle:Product')->findByParentCategory($parentCategory, $product, 3, $total);
        $stock = $em->getRepository('SfAdminBundle:ProductModel')->getStock($product);
        $sizes = $em->getRepository('SfAdminBundle:ProductModel')->getSizes($product);
        $colors = $em->getRepository('SfAdminBundle:ProductModel')->getColors($product);
        $materials = $em->getRepository('SfAdminBundle:ProductModel')->getMaterials($product);
        $numbers = $em->getRepository('SfAdminBundle:ProductModel')->getNumbers($product);
        
        if (!$product) {
            throw $this->createNotFoundException('This is product doesn\'t exist');
        }
        return array('sizes' => $sizes,
            'colors' => $colors,
            'materials' => $materials,
            'numbers' => $numbers,
            'stock' => $stock, 'product' => $product, 'moreProducts' => $moreProducts);
    }

    /**
     * 
     * @Route("/product/criterion/{product}",name="product_criterion",options = {"expose" = true})
     * @Template()
     */
    public function criterionsAction(Request $request, Product $product) {
        $params = $request->get('params', array());
        $em = $this->getDoctrine()->getManager();
        $criterions = $em->getRepository('SfAdminBundle:ProductModel')->getStockByCriterion($product, $params);

        return new JsonResponse(array('stock' => $criterions));
        // print_r($criterions);
        // die();
    }

}
