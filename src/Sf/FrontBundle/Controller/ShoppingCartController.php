<?php

namespace Sf\FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Sf\AdminBundle\Entity\Product;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sf\AdminBundle\Entity\Transaction;

class ShoppingCartController extends Controller {

    /**
     * @Route("/panier",name="front_shopping_cart")
     * @Template()
     */
    public function indexAction() {
        return array();
    }

    /**
     * @Route("/panier/detail",name="front_shopping_cart_show",options = {"expose" = true})
     * @Template()
     */
    public function shoppingCartAction(Request $request) {

        $token = $request->get('token',null);
          
        $session = $request->getSession();

        $products = $session->get('products', array());

        $em = $this->getDoctrine()->getManager();

        $user = $this->getUser();  
       
       // $token = null;
        $order = null;

        $shippingAddress = $em->getRepository('SfUserBundle:Address')->getPriorityAddress($user);
        //$data = array();
        # Add transaction
        $data = $this->get('shoppingcart')->getTotalAmount($user);

      // print_r($data); die();
        
        if ($user != null && $shippingAddress && $data['ttc'] > 0) {

          

               
                if ($token != null) {
                    $transaction = $em->getRepository('SfAdminBundle:Transaction')->findOneBy(array('token' => $token));
                } else {
                    $token = md5(time() . $user->getId());
                    $transaction = new Transaction();
                }

                $transaction->setAccount($user)
                        ->setAmountHt($data['ht'])
                        ->setAmountTtc($data['ttc'])
                        ->setTva($data['tva'])
                        ->setShippingCosts($data['shippingCosts'])
                        ->setCurrency('EUR')
                        ->setDate(new \DateTime())
                        ->setState('New')
                        ->setToken($token);

                $em->persist($transaction);
                $em->flush();

                $order = $this->get('order')->prepare($user, $transaction);
            
        }
        $paypalEmail = $this->container->getParameter('paypal_email');
        
       
        return array(
            'user' => $user,
            'products' => $products,
            'token' => $token,
            'shippingAddress' => $shippingAddress,
            'paypalEmail' => $paypalEmail,
            'price' => $data,
            'address' => $shippingAddress,
            'order' => $order
        );
         
         
        
    }

    /**
     * 
     * @Route("shopping-cart/add/{product}",name="front_shopping_cart_add",options = {"expose" = true})
     */
    public function add(Request $request, Product $product) {

        $em = $this->getDoctrine()->getManager();
        $params = $request->get('params', array());
        $stock = $em->getRepository('SfAdminBundle:ProductModel')->getStockByCriterion($product, $params);
        $isSameProduct = false;
        $data = array();
        if ($params['quantity'] <= $stock) {

            $session = $request->getSession();
            $products = $session->get('products', array());

            foreach ($products as $key => $p) {

                if ($p['product']->getId() == $product->getId()) {
                    $products[$key]['quantity'] = $p['quantity'] + $params['quantity'];
                    $isSameProduct = true;
                }
            }

            if (!$isSameProduct) {
                $data = array(array_merge(array('product' => $product), $params));
            }
            $session->set('products', array_merge($products, $data));

            $message = $this->container->get('translator')->trans('Ce produit a été ajouté au panier');
            $success = true;
        } else {
            $success = false;
            $message = $this->container->get('translator')->trans('Désolé, mais nous ne possédons que %nbStock% modèle(s) en stock pour ces critères', array('%nbStock%' => $stock));
        }
        return new JsonResponse(array('success' => $success, 'message' => $message));
    }

    /**
     * 
     * @Route("shopping-cart/remove/{product}",name="front_shopping_cart_remove",options = {"expose" = true})
     */
    public function remove(Request $request, Product $product) {


        $session = $request->getSession();
        $products = $session->get('products', array());
        //   \Doctrine\Common\Util\Debug::dump($products); die();
        foreach ($products as $key => $value) {

            if ($value['product']->getId() == $product->getId()) {
                unset($products[$key]);
            }
        }



        $session->set('products', $products);


        $success = true;

        return new JsonResponse(array(
            'success' => $success,
            'html' => $this->forward('SfFrontBundle:ShoppingCart:shoppingcart')->getContent()));
    }

    /**
     * 
     * @Route("shopping-cart/update/{product}/{quantity}",name="front_shopping_cart_update",options = {"expose" = true,"i18n"= false})
     */
    public function update(Request $request, Product $product = null, $quantity = 1) {

        $token = $request->get('token',null);
        $success = true;

        if ($product != null) {
            $em = $this->getDoctrine()->getManager();
            $session = $request->getSession();
            $products = $session->get('products', array());


            foreach ($products as $key => $value) {

                if ($value['product']->getId() == $product->getId()) {
                    $params = $value;
                    unset($params['product']);
                    $stock = $em->getRepository('SfAdminBundle:ProductModel')->getStockByCriterion($value['product'], $params);
                    if ($stock < $quantity) {
                        $products[$key]['quantity'] = $stock;
                        // $success = false;
                    } else {
                        $products[$key]['quantity'] = $quantity;
                    }
                }
            }

            $session->set('products', $products);
        }

        return new JsonResponse(array(
            'success' => $success,
            'html' => $this->forward('SfFrontBundle:ShoppingCart:shoppingCart',array('token' => $token))->getContent()));
    }
    /**
     * @Route("shopping-cart/total",name="front_shopping_cart_total",options = {"expose" = true})
     * @Template()
     */
    public function totalShoppingCartAction(){
        $data = $this->get('shoppingcart')->getTotalAmount($this->getUser());
        return array('total' => $data['ttc']);
    }

}
