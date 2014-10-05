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
    public function indexAction($categorySlug) {

        $em = $this->getDoctrine()->getManager();
        $category = $em->getRepository('SfAdminBundle:Category')->findOneBySlug($categorySlug);
        $products = $em->getRepository('SfAdminBundle:Product')->findBy(
                array('category' => $category->getId()), array('updatedAt' => 'desc'));
        return array('products' => $products, 'category' => $category
        );
    }

    /**
     * 
     *  @Route("/produit/{slug}",name="front_product")
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

        if (!$product) {
            throw $this->createNotFoundException('This is product doesn\'t exist');
        }
        return array('sizes' => $sizes,
            'colors' => $colors,
            'materials' => $materials,
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
