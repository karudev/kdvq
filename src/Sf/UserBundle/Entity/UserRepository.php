<?php

namespace Sf\UserBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Sf\UserBundle\Entity\User;

/**
 * NoteRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class UserRepository extends EntityRepository {

    public function getAll() {
        return $this->createQueryBuilder('e')
                        ->leftJoin('e.addresses', 'a')
                        ->orderBy('e.id', 'desc')
                        ->getQuery()
                        ->getResult();
    }

    public function getNbOrders(User $user) {
        $data = $this->createQueryBuilder('e')
                ->select('count(e.id) as nbOrders')
                ->innerJoin('e.orders', 'o')
                ->where('o.status !=:status')
                ->andWhere('e.id =:user')
                ->setParameter('status', 'New')
                ->setParameter('user', $user->getId())
                ->getQuery()
                ->getOneOrNullResult();

        return $data == null ? 0 : (int) $data['nbOrders'];
    }

    public function checkEmail(User $user = null) {
        $qb = $this->createQueryBuilder('e');


        $qb->where('e.email =:email');

        $qb->setParameter('email', $user->getEmail());


        $data = $qb->getQuery()
                ->getOneOrNullResult();
        if ($data != null) {
            if ($data->getId() == $user->getId()) {
                return false;
            }
        }
        return (bool) $data;
    }

    public function findOneByRole($role) {
        return $this->createQueryBuilder('u')
                ->where('u.roles LIKE :roles')
                ->setParameter('roles', '%"' . $role . '"%')
                ->getQuery()
                ->getSingleResult();
    }
    public function findByRole($role) {
        return $this->createQueryBuilder('u')
                ->where('u.roles LIKE :roles')
                ->andWhere('u.enabled = true')
                ->andWhere('u.locked = false')
                ->andWhere('u.expired = false')
                ->setParameter('roles', '%"' . $role . '"%')
                ->orderBy('u.socialName','asc')
                ->getQuery()
                ->getResult();
    }

}
