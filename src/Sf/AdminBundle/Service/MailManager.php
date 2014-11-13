<?php

namespace Sf\AdminBundle\Service;

use Sf\UserBundle\Entity\User;
use Sf\AdminBundle\Entity\Brand;
use Sf\AdminBundle\Entity\Order;
use Sf\AdminBundle\Entity\Mail;

class MailManager {

    public $container;

    public function __construct($container) {
        $this->container = $container;
    }

    public function insert(Order $order, $subject, $text, $senderUser = null, User $senderBrand = null, User $receiverUser = null, Brand $receiverBrand = null, $type = 'admin',$typeReceiver = 'shop') {
        $em = $this->container->get('doctrine')->getManager();
        
        if($senderUser == 'admin'){
            $senderUser = $em->getRepository('SfUserBundle:User')->findOneByRole('ROLE_ADMIN');
        }
        $m = new Mail();
        $m->setSendAt(new \DateTime)
                ->setOrder($order)
               // ->setReceiverBrand($receiverBrand)
                ->setReceiverUser($receiverUser)
                ->setSubject($subject)
                ->setText($text)
                ->setSenderUser($senderUser)
               // ->setSenderBrand($senderBrand)
                ->setType($type)
                ->setTypeReceiver($typeReceiver);
        $em->persist($m);
        $em->flush();
        
        return $m;
    }

}
