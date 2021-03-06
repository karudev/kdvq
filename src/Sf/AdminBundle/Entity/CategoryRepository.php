<?php

namespace Sf\AdminBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * CategoryRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CategoryRepository extends EntityRepository
{
    public function getQueryBuilder(){
        return $this->createQueryBuilder('e')
                ->innerJoin('e.category', 'c')
                ->where('e.active = true')
                ->andWhere('e.mostLowLevel = true')
                ->orderBy('c.id','asc')
                ->addOrderBy('e.id','asc');
    }
  
}
