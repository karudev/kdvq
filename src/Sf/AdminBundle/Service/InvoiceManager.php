<?php

namespace Sf\AdminBundle\Service;

use Sf\AdminBundle\Entity\Order;
use Sf\AdminBundle\Entity\Invoice;

class InvoiceManager {

    public $container;

    public function __construct($container) {
        $this->container = $container;
    }

    public function create(Order $order) {
        $em = $this->container->get('doctrine')->getManager();
        $account = $order->getAccount();
        $invoice = new Invoice();
        $invoice->setCreatedAt(new \DateTime)
                ->setAccount($account)
                ->setTransaction($order->getTransaction())
                ->setOrder($order)
                ->setAmountHt($order->getAmountHt())
                ->setAmountTtc($order->getAmountTtc())
                ->setTva($order->getTva())
                ->setShippingCosts($order->getShippingCosts())
                ->setType($order->getType());

        $order->setInvoice($invoice);
        
        $address = $em->getRepository('SfUserBundle:Address')->getPriorityAddress($account);
        $invoice->setTitleAddress($address->getTitle())
                ->setAddress($address->getAddress())
                ->setAdditionalAddress($address->getAdditionalAddress())
                ->setZipCode($address->getZipCode())
                ->setCity($address->getCity())
                ->setCountry($address->getCountry());

        foreach ($order->getProductModels() as $pm) {
            $pm->setInvoice($invoice);
            $em->persist($pm);
            $invoice->addProductModel($pm);
        }
        $em->persist($invoice);
       // $em->persist($order);
        $em->flush();

        return $order;
    }

}
