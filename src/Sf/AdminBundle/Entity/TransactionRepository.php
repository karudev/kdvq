<?php

namespace Sf\AdminBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * SizeRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class TransactionRepository extends EntityRepository
{
  public function checkout($params){
      
     return  $this->createQueryBuilder('e')
              ->innerJoin('e.account', 'a')
              ->where('e.amounTtc =:amountTtc')
              ->andWhere('e.currency =:currency')
              ->andWhere('e.tva =:tva')
              ->andWhere('e.shippingCosts =:shipping')
              ->andWhere('e.token =:token')
              ->setParameter('amountTtc', $params['amountTtc'])
              ->setParameter('currency', $params['currency'])
              ->setParameter('tva', $params['tva'])
              ->setParameter('shipping', $params['shipping'])
              ->setParameter('token', $params['token'])
              ->getQuery()
              ->getOneOrNullResult();
  }
}
