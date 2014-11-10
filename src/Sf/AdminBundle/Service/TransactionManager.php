<?php

namespace Sf\AdminBundle\Service;

use Sf\AdminBundle\Entity\Order;
use Sf\UserBundle\Entity\User;
use Sf\AdminBundle\Entity\Transaction;

class TransactionManager {

    public $container;

    public function __construct($container) {
        $this->container = $container;
    }

    public function invalid(Transaction $transaction) {
        $em = $this->container->get('doctrine')->getManager();
        $transaction->setState('Invalid');
        $this->container->get('sf_user.mail_helper')->fraud($transaction);
        $transaction->setDate(new \Datetime())
               ;

        $em->persist($transaction);
        $em->flush();


        $order = $em->getRepository('SfAdminBundle:Order')->findOneBy(array('transaction' => $transaction->getId()));
        $em->remove($order);
        $em->flush();
    }

    public function verified(Transaction $transaction, $payment_status) {
        $em = $this->container->get('doctrine')->getManager();
        $transaction->setState($payment_status);
        $transaction->setDate(new \Datetime());
              
        $em->persist($transaction);
        $em->flush();


        if ($payment_status == 'Pending' || $payment_status == 'Completed') {
            # Update the order
            $order = $this->container->get('order')->update(
                    $transaction->getAccount(), $transaction->getAmountHt(), $transaction->getAmountTtc(), $transaction->getTva(), $transaction->getShippingCosts(), $transaction
            );
            # Send email
            if ($order) {
                $this->container->get('sf_user.mail_helper')->confirmOrder($order);
            }
        }
    }

}
