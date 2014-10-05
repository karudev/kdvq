<?php

namespace Sf\AdminBundle\Service;

use Sf\AdminBundle\Entity\Product;

class ProductManager {

    public $container;

    public function __construct($container) {
        $this->container = $container;
    }

    public function setTva(Product $product, $persistAndFlush = true) {

        $tvaPercent = $product->getGroup()->getBrand()->getTvaPercent();
        if ($tvaPercent == null) {
            $tvaPercent = 0;
        } else {
            $tvaPercent = $tvaPercent / 100;
        }
        $tvaBtoB = $product->getSellerPrice() * $tvaPercent;
        $tvaBtoC = $product->getRecommendedRetailPrice() * $tvaPercent;
        $product->setTvaBtoB($tvaBtoB)
                ->setTvaBtoC($tvaBtoC);

        $em = $this->container->get('doctrine')->getManager();
        $product->setUpdatedAt(new \DateTime);

        if ($persistAndFlush) {
            $em->persist($product);
            $em->flush();
        }

        return $product;
    }

   

}
