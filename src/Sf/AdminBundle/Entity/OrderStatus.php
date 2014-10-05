<?php

namespace Sf\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * OrderStatus
 *
 * @ORM\Table(name="order_status")
 * @ORM\Entity()
 */
class OrderStatus
{

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    
   /**
     * @ORM\ManyToOne(targetEntity="Order", inversedBy="orderStatus")
     */
    private $order;
    
    /**
     * @var string
     * 
     * @ORM\Column(name="status", type="string", length=64)
     */
    private $status;
   
   


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set status
     *
     * @param string $status
     * @return OrderStatus
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return string 
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set order
     *
     * @param \Sf\AdminBundle\Entity\Order $order
     * @return OrderStatus
     */
    public function setOrder(\Sf\AdminBundle\Entity\Order $order = null)
    {
        $this->order = $order;

        return $this;
    }

    /**
     * Get order
     *
     * @return \Sf\AdminBundle\Entity\Order 
     */
    public function getOrder()
    {
        return $this->order;
    }
}
