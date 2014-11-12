<?php

namespace Sf\AdminBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Sf\AdminBundle\Entity\Product;
use Sf\AdminBundle\Entity\Order;
use Sf\AdminBundle\Entity\Invoice;

/**
 * ProductModelRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ProductModelRepository extends EntityRepository {

    public function get(Product $product) {
        $data = $this->createQueryBuilder('e')
                ->where('e.product =:product')
                ->andWhere('e.order is null')
                ->andWhere('e.deleted = false')
                ->setParameter('product', $product->getId())
                ->orderBy('e.id', 'desc')
                ->getQuery()
                ->getResult();

        return $data;
    }

    public function getStock(Product $product) {
        $data = $this->createQueryBuilder('e')
                ->select('count(e.id) as stock')
                ->where('e.product =:product')
                ->andWhere('e.order is null')
                ->andWhere('e.deleted = false')
                ->setParameter('product', $product->getId())
                ->getQuery()
                ->getSingleResult();

        if (count($data) > 0) {
            return (int) $data['stock'];
        } else {
            return 0;
        }
    }

    public function getSizes(Product $product) {
        return $this->createQueryBuilder('e')
                        ->select('s.id,s.name')
                        ->distinct('s.id')
                        ->innerJoin('e.size', 's')
                        ->where('e.product =:product')
                        ->andWhere('e.order is null')
                        ->andWhere('e.deleted = false')
                        ->setParameter('product', $product->getId())
                        ->orderBy('s.name', 'asc')
                        ->getQuery()
                        ->getResult();
    }

    public function getColors(Product $product) {
        return $this->createQueryBuilder('e')
                        ->select('s.id,s.name')
                        ->distinct('s.id')
                        ->innerJoin('e.color', 's')
                        ->where('e.product =:product')
                        ->andWhere('e.order is null')
                        ->andWhere('e.deleted = false')
                        ->setParameter('product', $product->getId())
                        ->orderBy('s.name', 'asc')
                        ->getQuery()
                        ->getResult();
    }

    public function getMaterials(Product $product) {
        return $this->createQueryBuilder('e')
                        ->select('s.id,s.name')
                        ->distinct('s.id')
                        ->innerJoin('e.material', 's')
                        ->where('e.product =:product')
                        ->andWhere('e.order is null')
                        ->andWhere('e.deleted = false')
                        ->setParameter('product', $product->getId())
                        ->orderBy('s.name', 'asc')
                        ->getQuery()
                        ->getResult();
    }
    
     public function getNumbers(Product $product) {
        return $this->createQueryBuilder('e')
                        ->select('s.id,s.name')
                        ->distinct('s.id')
                        ->innerJoin('e.numberEntity', 's')
                        ->where('e.product =:product')
                        ->andWhere('e.order is null')
                        ->andWhere('e.deleted = false')
                        ->setParameter('product', $product->getId())
                        ->orderBy('s.name', 'asc')
                        ->getQuery()
                        ->getResult();
    }

    public function getStockByCriterion(Product $product, $params = array()) {

        $qb = $this->createQueryBuilder('e');
        $qb->select('count(e.id) as stock')
                ->leftJoin('e.size', 's')
                ->leftJoin('e.material', 'm')
                ->leftJoin('e.color', 'c')
                ->leftJoin('e.numberEntity', 'n')
                ->where('e.product =:product')
                ->andWhere('e.order is null')
                ->andWhere('e.deleted = false')
                ->setParameter('product', $product->getId())
                ->orderBy('s.name', 'asc');

        if (isset($params['size']) && $params['size'] > 0) {
            $qb->andWhere('s.id=:size')
                    ->setParameter('size', (int) $params['size']);
        }
        if (isset($params['color']) && $params['color'] > 0) {
            $qb->andWhere('c.id=:color')
                    ->setParameter('color', (int) $params['color']);
        }
        if (isset($params['material']) && $params['material'] > 0) {
            $qb->andWhere('m.id=:material')
                    ->setParameter('material', (int) $params['material']);
        }
        if (isset($params['number']) && $params['number'] > 0) {
            $qb->andWhere('n.id=:number')
                    ->setParameter('number', (int) $params['number']);
        }

        $data = $qb->getQuery()
                ->getSingleResult();

        if (count($data) > 0) {
            return (int) $data['stock'];
        } else {
            return 0;
        }
    }

    public function getProductModelsGroupByRef(Order $order = null, Product $product = null, Invoice $invoice = null) {
        $qb = $this->createQueryBuilder('e');
        $qb->select('count(e.number) as quantity')
                ->addSelect('p.id as productId')
                ->addSelect('e.number')
                ->addSelect('sum(p.priceHt) as priceHt')
                ->addSelect('sum(p.priceTtc) as priceTtc')
                ->addSelect('sum(p.tva) as tva')
                ->addSelect('s.name as size')
                ->addSelect('c.name as color')
                ->addSelect('m.name as material')
                ->addSelect('n.name as numberEntity')
                ->addSelect('p.name as name')
                ->innerJoin('e.product', 'p')
               // ->innerJoin('p.group', 'g')
               // ->innerJoin('g.brand', 'b')
                ->leftJoin('e.size', 's')
                ->leftJoin('e.color', 'c')
                ->leftJoin('e.material', 'm')
                ->leftJoin('e.numberEntity', 'n');
        if ($order != null) {
            $qb->where('e.order =:order')->setParameter('order', $order->getId());
        }
        if ($invoice != null) {
            $qb->where('e.invoice =:invoice')->setParameter('invoice', $invoice->getId());
        }

        if ($product != null) {
            $qb->where('e.product =:product')
                    ->andWhere('e.order is null')
                    ->andWhere('e.deleted = false')
                    ->setParameter('product', $product->getId());
        }

        //$qb->groupBy('e.number')

        $qb->groupBy('s.name')
                ->addGroupBy('p.id')
                ->addGroupBy('p.name')
                ->addGroupBy('c.name')
                ->addGroupBy('m.name')
                ->addGroupBy('n.name');

        return $qb->getQuery()
                        ->getResult();
    }

}
