<?php

namespace Sf\AdminBundle\Service;

use Sf\UserBundle\Entity\User;
use Sf\AdminBundle\Entity\ShoppingCart;
use Sf\AdminBundle\Entity\Transaction;
use Sf\AdminBundle\Entity\Order;

class ShoppingCartManager {

    public $container;

    public function __construct($container) {
        $this->container = $container;
    }

    public function getTotalAmount(User $user = null) {
        $em = $this->container->get('doctrine')->getManager();
        $request = $this->container->get('request');
        $products = $request->getSession()->get('products', array());
        $ht = 0;
        $ttc = 0;
        $tva = 0;
        $ttcBybrand = array();
        $infos = array();
        $promos = array();
       
        $bool = false;
      
       $shipping_costs = $em->getRepository('SfAdminBundle:Config')->findOneBy(array('name' => 'shipping_costs'));
       if(!$shipping_costs){
            $shippingCosts = 0;
       }else{
           $shippingCosts = $shipping_costs->getValue();
       }
     
       

        foreach ($products as $key => $value) {

          
            $ht +=  $value['product']->getPriceHt() * $value['quantity'];
            $tva += $value['product']->getTva() * $value['quantity'];
            $ttc += $value['quantity'] * $value['product']->getPriceTtc();




         
        }
     
        //$ttc = $ht + $tva;



        // die($ttc - $ht);
        return array(
            'ht' => $ht,
            'ttc' => $ttc + $shippingCosts,
            'tva' => $tva,
            'currency' => 'EUR',
            'shippingCosts' => $shippingCosts,
            'infos' => $infos,
            'promos' => $promos);
    }

    public function save(User $user, Transaction $transaction = null, $token = null) {
        $em = $this->container->get('doctrine')->getManager();
        $request = $this->container->get('request');
        $products = $request->getSession()->get('products', array());
        foreach ($products as $value) {
            $s = new ShoppingCart;
            $s->setAccount($user)
                    ->setCreatedAt(new \DateTime)
                    ->setQuantity($value['quantity']);

            if (isset($value['color'])) {
                $s->setColor($value['color']);
            }

            if (isset($value['size'])) {
                $s->setSize($value['size']);
            }

            if (isset($value['material'])) {
                $s->setMaterial($value['material']);
            }

            $s->setTransaction($transaction)
                   
                    ->setToken($token)
                    ->setProduct($em->getRepository('SfAdminBundle:Product')->find($value['product']));
            $em->persist($s);
        }
        $em->flush();
        $this->reset();
    }

    public function reset() {
        $request = $this->container->get('request');
        $request->getSession()->remove('products');
    }

   

}
