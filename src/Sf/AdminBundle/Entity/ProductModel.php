<?php

namespace Sf\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ProductModel
 *
 * @ORM\Table(name="product_model")
 * @ORM\Entity(repositoryClass="Sf\AdminBundle\Entity\ProductModelRepository")
 * @ORM\HasLifecycleCallbacks
 */
class ProductModel {

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

  
    
    /**
     * @ORM\ManyToOne(targetEntity="Product", inversedBy="productModels")
     */
    private $product;
    
    /**
     * @ORM\ManyToOne(targetEntity="Size")
     * @ORM\JoinColumn(name="size_id", referencedColumnName="id", nullable = true)
     */
    private $size;
    
     /**
     * @ORM\ManyToOne(targetEntity="Color")
      * @ORM\JoinColumn(name="color_id", referencedColumnName="id", nullable = true)
     */
    private $color;
    
     /**
     * @ORM\ManyToOne(targetEntity="Material")
      * @ORM\JoinColumn(name="material_id", referencedColumnName="id", nullable = true)
     */
    private $material;
    
     /**
     * @ORM\ManyToOne(targetEntity="Order", inversedBy="productModels" )
      * @ORM\JoinColumn(name="order_id", referencedColumnName="id", nullable = true)
     */
    private $order;
    
    /**
     * @ORM\ManyToOne(targetEntity="Invoice", inversedBy="productModels" )
      * @ORM\JoinColumn(name="invoice_id", referencedColumnName="id", nullable = true)
     */
    private $invoice;
    
     /**
     * @var boolean
     *
     * @ORM\Column(name="deleted", type="boolean")
     */
    private $deleted = false;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime")
     */
    private $updatedAt;
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="deleted_at", type="datetime", nullable = true)
     */
    private $deletedAt;
    
     /**
     * @var string
     *
     * @ORM\Column(name="number", type="string",length = 128)
     */
    private $number;

    

   /* public function getNumber()
    {
        $brandRef = $this->getProduct()->getGroup()->getBrand()->getReference();
        return 'P'.$brandRef.str_pad($this->id,6,"0",STR_PAD_LEFT);
    }
    */
    /**
     * @ORM\PrePersist
     */
    public function CcreatedDateTime() {
        $this->createdAt = new \DateTime();
        $this->updatedAt = new \DateTime();
    }

    /**
     * @ORM\PreUpdate()
     */
    public function updatedDateTime() {
        $this->updatedAt = new \dateTime();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId() {
        return $this->id;
    }

  

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Config
     */
    public function setCreatedAt($createdAt) {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt() {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     * @return Config
     */
    public function setUpdatedAt($updatedAt) {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt() {
        return $this->updatedAt;
    }

   

    


 
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->taxonomies = new \Doctrine\Common\Collections\ArrayCollection();
    }

 

    

    
    /**
     * Set product
     *
     * @param \Sf\AdminBundle\Entity\Product $product
     * @return ProductModel
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
     * Set size
     *
     * @param string $size
     * @return ProductModel
     */
    public function setSize($size)
    {
        $this->size = $size;

        return $this;
    }

    /**
     * Get size
     *
     * @return string 
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * Set color
     *
     * @param string $color
     * @return ProductModel
     */
    public function setColor($color)
    {
        $this->color = $color;

        return $this;
    }

    /**
     * Get color
     *
     * @return string 
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * Set material
     *
     * @param string $material
     * @return ProductModel
     */
    public function setMaterial($material)
    {
        $this->material = $material;

        return $this;
    }

    /**
     * Get material
     *
     * @return string 
     */
    public function getMaterial()
    {
        return $this->material;
    }

    /**
     * Set deleted
     *
     * @param boolean $deleted
     * @return ProductModel
     */
    public function setDeleted($deleted)
    {
        $this->deleted = $deleted;

        return $this;
    }

    /**
     * Get deleted
     *
     * @return boolean 
     */
    public function getDeleted()
    {
        return $this->deleted;
    }

    /**
     * Set deletedAt
     *
     * @param \DateTime $deletedAt
     * @return ProductModel
     */
    public function setDeletedAt($deletedAt)
    {
        $this->deletedAt = $deletedAt;

        return $this;
    }

    /**
     * Get deletedAt
     *
     * @return \DateTime 
     */
    public function getDeletedAt()
    {
        return $this->deletedAt;
    }

    /**
     * Set order
     *
     * @param \Sf\AdminBundle\Entity\Order $order
     * @return ProductModel
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
     * 
     *
     * @param string $number
     * @return ProductModel
     */
    public function setNumber($number = null)
    {
        
        $size = str_pad(($this->getSize() == null ? 0 : $this->getSize()->getId()) ,2,"0",STR_PAD_LEFT);
        $color = str_pad(($this->getColor() == null ? 0 : $this->getColor()->getId()),2,"0",STR_PAD_LEFT);
        $material = str_pad(($this->getMaterial() == null ? 0 : $this->getMaterial()->getId()),2,"0",STR_PAD_LEFT);
        
        $this->number = 'P.'.$size.'.'.$color.'.'.$material.'.'.str_pad($this->getProduct()->getId(),6,"0",STR_PAD_LEFT);

        return $this;
    }

    /**
     * Get number
     *
     * @return string 
     */
    public function getNumber()
    {
       
        return $this->number;
    }

    /**
     * Set invoice
     *
     * @param \Sf\AdminBundle\Entity\Invoice $invoice
     * @return ProductModel
     */
    public function setInvoice(\Sf\AdminBundle\Entity\Invoice $invoice = null)
    {
        $this->invoice = $invoice;

        return $this;
    }

    /**
     * Get invoice
     *
     * @return \Sf\AdminBundle\Entity\Invoice 
     */
    public function getInvoice()
    {
        return $this->invoice;
    }
}
