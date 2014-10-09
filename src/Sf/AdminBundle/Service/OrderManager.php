<?php

namespace Sf\AdminBundle\Service;

use Sf\AdminBundle\Entity\Order;
use Sf\UserBundle\Entity\User;
use Sf\AdminBundle\Entity\Transaction;
use Sf\AdminBundle\Entity\OrderBrand;

class OrderManager {

    public $container;

    public function __construct($container) {
        $this->container = $container;
    }

    public function prepare(User $user, Transaction $transaction = null) {
        $em = $this->container->get('doctrine')->getManager();
        $order = new Order();
        $order->setAccount($user)
                ->setTransaction($transaction)
                ->setStatus('New');
        $em->persist($order);
        $em->flush();

        return $order;
    }

    public function update(User $user, $amountHt, $amountTtc, $tva, $shippingCosts, Transaction $transaction = null, $token = null) {
        $em = $this->container->get('doctrine')->getManager();
        $now = new \DateTime;
        $estimated = clone $now;
        $estimated->modify('+2 weeks');

        $address = $em->getRepository('SfUserBundle:Address')->getPriorityAddress($user);
        if ($address != null) {
            if ($transaction != null) {
                $order = $em->getRepository('SfAdminBundle:Order')->findOneBy(array(
                    'account' => $user->getId(),
                    'transaction' => $transaction->getId()));
            } else {
                $order = $this->prepare($user);
            }

            $order->setAmountHt($amountHt)
                    ->setAmountTtc($amountTtc)
                    ->setTva($tva)
                    ->setShippingCosts($shippingCosts)
                    ->setOrderDate($now)
                    ->setEstimatedDelivaryDate($estimated)
                    ->setTransaction($transaction)
                    ->setTitleAddress($address->getTitle())
                    ->setAddress($address->getAddress())
                    ->setAdditionalAddress($address->getAdditionalAddress())
                    ->setCity($address->getCity())
                    ->setCountry($address->getCountry())
                    ->setZipCode($address->getZipCode())
                    ->setStatus('In-Progress');

            if ($token != null) {
                $order->setType('S');
            }
            $em->persist($order);
            $em->flush();

            # update shopping cart
            if ($order->getTransaction() != null) {
                $sp = $em->getRepository('SfAdminBundle:ShoppingCart')->findOneBy(array('transaction' => $order->getTransaction()));
            }elseif ($token!= null) {
                $sp = $em->getRepository('SfAdminBundle:ShoppingCart')->findOneBy(array('token' => $token));
            }
            $sp->setOrder($order);
                $em->persist($sp);
                $em->flush();

            $this->linkProductsModel($order, $token);


            return $order;
        }
        return false;
    }

    public function linkProductsModel(Order $order, $token = null) {
        //$request = $this->container->get('request');

        $em = $this->container->get('doctrine')->getManager();
        if ($token != null) {
            $products = $em->getRepository('SfAdminBundle:ShoppingCart')->findBy(array('token' => $token));
        } else {
            $products = $em->getRepository('SfAdminBundle:ShoppingCart')->findBy(array('transaction' => $order->getTransaction()->getId()));
        }
        $success = true;
        $errors = array();
     //   $brands = array();
        foreach ($products as $key => $value) {
            $params = array('deleted' => false, 'product' => $value->getProduct()->getId(), 'order' => null);
            if ($value->getSize() != null && $value->getSize() != 0) {
                $params['size'] = $value->getSize();
            }
            if ($value->getColor() != null && $value->getColor() != 0) {
                $params['color'] = $value->getColor();
            }
            if ($value->getMaterial() != null && $value->getMaterial() != 0) {
                $params['material'] = $value->getMaterial();
            }
            for ($i = 0; $i < (int) $value->getQuantity(); $i++) {
                $productModel = $em->getRepository('SfAdminBundle:ProductModel')->findOneBy($params);
                if ($productModel) {
                    $productModel->setOrder($order);
                    $em->persist($productModel);
                    $em->flush();

                  //  $brand = $productModel->getProduct()->getGroup()->getBrand();
                    //$brands[$brand->getId()] = $brand;
                } else {
                    $success = false;
                    $errors = array_merge($errors, array($params));
                }
            }
        }
       // $this->linkOrderBrand($order, $brands);

        return array('success' => $success, 'errors' => $errors);
    }

    public function linkOrderBrand(Order $order, $brands = array()) {
        $em = $this->container->get('doctrine')->getManager();
        foreach ($brands as $b) {
            $ob = new OrderBrand;
            $ob->setBrand($b)
                    ->setOrder($order);
            $em->persist($ob);
            $em->flush();
        }
    }

    public function initStatus(Order $order) {
        $em = $this->container->get('doctrine')->getManager();
        $qb = $em->getRepository('SfAdminBundle:OrderStatus')->createQueryBuilder('e');
        $data = $qb->where('e.order =:order')
                        ->setParameter('order', $order->getId())
                        ->getQuery()->getResult();
        foreach ($data as $value) {
            $em->remove($value);
        }
        $em->flush();
    }

}
