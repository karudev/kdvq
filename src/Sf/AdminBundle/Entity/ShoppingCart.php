<?php

namespace Sf\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * ShoppingCart
 *
 * @ORM\Table(name="shopping_cart")
 * @ORM\Entity()
 * @ORM\HasLifecycleCallbacks
 */
class ShoppingCart
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
     * @var string
     * @ORM\Column(name="token", type="string",nullable = true)
     */
    private $token;
    
    /**
     * @ORM\ManyToOne(targetEntity="Transaction",cascade={"persist"})
     * @ORM\JoinColumn(name="transaction_id", referencedColumnName="id",nullable=true)
     */
    private $transaction;
    
     /**
     * @ORM\ManyToOne(targetEntity="Order")
     * @ORM\JoinColumn(name="order_id", referencedColumnName="id",nullable=true)
     */
    private $order;
    
     /**
     * @ORM\ManyToOne(targetEntity="Sf\UserBundle\Entity\User")
     * @ORM\JoinColumn(name="account_id", referencedColumnName="id")
     */
    private $account;
    
    /**
     * @ORM\ManyToOne(targetEntity="Product",cascade={"persist"})
     * @ORM\JoinColumn(name="product_id", referencedColumnName="id")
     */
    private $product;
    
    /**
     * @var integer
     * @ORM\Column(name="size", type="integer",nullable = true)
     */
    private $size;
    
     /**
     * @var integer
     * @ORM\Column(name="color", type="integer",nullable = true)
     */
    private $color;
    
    /**
     * @var integer
     * @ORM\Column(name="material", type="integer", nullable = true)
     */
    private $material;
    
    
    /**
     * @var integer
     * @ORM\Column(name="number", type="integer", nullable = true)
     */
    private $number;

    
     /**
     * @var integer
     * @ORM\Column(name="quantity", type="integer")
     */
    private $quantity;
    
    
     /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;
    
   


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
     * Set size
     *
     * @param integer $size
     * @return ShoppingCart
     */
    public function setSize($size)
    {
        $this->size = $size;

        return $this;
    }

    /**
     * Get size
     *
     * @return integer 
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * Set color
     *
     * @param integer $color
     * @return ShoppingCart
     */
    public function setColor($color)
    {
        $this->color = $color;

        return $this;
    }

    /**
     * Get color
     *
     * @return integer 
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * Set material
     *
     * @param integer $material
     * @return ShoppingCart
     */
    public function setMaterial($material)
    {
        $this->material = $material;

        return $this;
    }

    /**
     * Get material
     *
     * @return integer 
     */
    public function getMaterial()
    {
        return $this->material;
    }

    /**
     * Set quantity
     *
     * @param integer $quantity
     * @return ShoppingCart
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * Get quantity
     *
     * @return integer 
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return ShoppingCart
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime 
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

  
    /**
     * Set account
     *
     * @param \Sf\UserBundle\Entity\User $account
     * @return ShoppingCart
     */
    public function setAccount(\Sf\UserBundle\Entity\User $account = null)
    {
        $this->account = $account;

        return $this;
    }

    /**
     * Get account
     *
     * @return \Sf\UserBundle\Entity\User 
     */
    public function getAccount()
    {
        return $this->account;
    }

    /**
     * Set product
     *
     * @param \Sf\AdminBundle\Entity\Product $product
     * @return ShoppingCart
     */
    public function setProduct(\Sf\AdminBundle\Entity\Product $product = null)
    {
        $this->product = $product;

        return $this;
    }

    /**
     * Get product
     *
     * @return \Sf\AdminBundle\Entity\Product 
     */
    public function getProduct()
    {
        return $this->product;
    }

   
    /**
     * Set transaction
     *
     * @param \Sf\AdminBundle\Entity\Transaction $transaction
     * @return ShoppingCart
     */
    public function setTransaction(\Sf\AdminBundle\Entity\Transaction $transaction = null)
    {
        $this->transaction = $transaction;

        return $this;
    }

    /**
     * Get transaction
     *
     * @return \Sf\AdminBundle\Entity\Transaction 
     */
    public function getTransaction()
    {
        return $this->transaction;
    }

    /**
     * Set token
     *
     * @param string $token
     * @return ShoppingCart
     */
    public function setToken($token)
    {
        $this->token = $token;

        return $this;
    }

    /**
     * Get token
     *
     * @return string 
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * Set order
     *
     * @param \Sf\AdminBundle\Entity\Order $order
     * @return ShoppingCart
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

    /**
     * Set number
     *
     * @param integer $number
     * @return ShoppingCart
     */
    public function setNumber($number)
    {
        $this->number = $number;

        return $this;
    }

    /**
     * Get number
     *
     * @return integer 
     */
    public function getNumber()
    {
        return $this->number;
    }
}
