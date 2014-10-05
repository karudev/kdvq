<?php

namespace Sf\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Invoice
 *
 * @ORM\Table(name="invoice")
 * @ORM\Entity(repositoryClass="Sf\AdminBundle\Entity\OrderRepository")
 */
class Invoice
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
     * @var \DateTime
     *
     * @ORM\Column(name="createdAt", type="datetime")
     */
    private $createdAt;
    
     /**
     * @ORM\ManyToOne(targetEntity="Sf\UserBundle\Entity\User",)
     * @ORM\JoinColumn(name="account_id", referencedColumnName="id")
     */
    private $account;
    
    /**
     * @ORM\ManyToOne(targetEntity="Transaction")
     * @ORM\JoinColumn(name="transaction_id", referencedColumnName="id", nullable = true)
     */
    private $transaction;
    
    
     /**
     * @ORM\OneToOne(targetEntity="Order", inversedBy="invoice")
     * @ORM\JoinColumn(name="order_id", referencedColumnName="id")
     */
    private $order;

    /**
     * @var float
     * 
     * @ORM\Column(name="amount_ht", type="float")
     */
    private $amountHt = 0;
   
     /**
     * @var float
     * 
     * @ORM\Column(name="amount_ttc", type="float")
     */
    private $amountTtc = 0;
    
    /**
     * @var float
     * 
     * @ORM\Column(name="tva", type="float")
     */
    private $tva = 0;
    
    /**
     * @var float
     * 
     * @ORM\Column(name="shipping_costs", type="float")
     */
    private $shippingCosts = 0;
    
      /**
     * @var string
     * @ORM\Column(name="title_address", type="string", length=128, nullable=true)
     */
    private $titleAddress;
    
     /**
     * @var string
     * @ORM\Column(name="address", type="string", length=255, nullable = true)
     */
    private $address;
    
    /**
     * @var string
     * @ORM\Column(name="additional_address", type="string", length=255, nullable=true)
     */
    private $additionalAddress;
    
    /**
     * @var string
     * @ORM\Column(name="zip_code", type="string", length=32, nullable = true)
     */
    private $zipCode;
    
     /**
     * @var string
     * @ORM\Column(name="city", type="string", length=128, nullable = true)
     */
    private $city;
    
     /**
     * @var string
     * @ORM\Column(name="country", type="string", length=128, nullable = true)
     */
    private $country;
   
    
    /**
     * @var string
     * @ORM\Column(name="type", type="string", length=1)
     */
    private $type = 'C';
    
    
  
    
    /**
     *
     *  @ORM\OneToMany(targetEntity="ProductModel", mappedBy="invoice")
     */
    private $productModels;
    
 
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->productModels = new \Doctrine\Common\Collections\ArrayCollection();
    }

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
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Invoice
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
     * Set amountHt
     *
     * @param float $amountHt
     * @return Invoice
     */
    public function setAmountHt($amountHt)
    {
        $this->amountHt = $amountHt;

        return $this;
    }

    /**
     * Get amountHt
     *
     * @return float 
     */
    public function getAmountHt()
    {
        return $this->amountHt;
    }

    /**
     * Set amountTtc
     *
     * @param float $amountTtc
     * @return Invoice
     */
    public function setAmountTtc($amountTtc)
    {
        $this->amountTtc = $amountTtc;

        return $this;
    }

    /**
     * Get amountTtc
     *
     * @return float 
     */
    public function getAmountTtc()
    {
        return $this->amountTtc;
    }

    /**
     * Set tva
     *
     * @param float $tva
     * @return Invoice
     */
    public function setTva($tva)
    {
        $this->tva = $tva;

        return $this;
    }

    /**
     * Get tva
     *
     * @return float 
     */
    public function getTva()
    {
        return $this->tva;
    }

    /**
     * Set shippingCosts
     *
     * @param float $shippingCosts
     * @return Invoice
     */
    public function setShippingCosts($shippingCosts)
    {
        $this->shippingCosts = $shippingCosts;

        return $this;
    }

    /**
     * Get shippingCosts
     *
     * @return float 
     */
    public function getShippingCosts()
    {
        return $this->shippingCosts;
    }

    /**
     * Set titleAddress
     *
     * @param string $titleAddress
     * @return Invoice
     */
    public function setTitleAddress($titleAddress)
    {
        $this->titleAddress = $titleAddress;

        return $this;
    }

    /**
     * Get titleAddress
     *
     * @return string 
     */
    public function getTitleAddress()
    {
        return $this->titleAddress;
    }

    /**
     * Set address
     *
     * @param string $address
     * @return Invoice
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return string 
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set additionalAddress
     *
     * @param string $additionalAddress
     * @return Invoice
     */
    public function setAdditionalAddress($additionalAddress)
    {
        $this->additionalAddress = $additionalAddress;

        return $this;
    }

    /**
     * Get additionalAddress
     *
     * @return string 
     */
    public function getAdditionalAddress()
    {
        return $this->additionalAddress;
    }

    /**
     * Set zipCode
     *
     * @param string $zipCode
     * @return Invoice
     */
    public function setZipCode($zipCode)
    {
        $this->zipCode = $zipCode;

        return $this;
    }

    /**
     * Get zipCode
     *
     * @return string 
     */
    public function getZipCode()
    {
        return $this->zipCode;
    }

    /**
     * Set city
     *
     * @param string $city
     * @return Invoice
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return string 
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set country
     *
     * @param string $country
     * @return Invoice
     */
    public function setCountry($country)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get country
     *
     * @return string 
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Set type
     *
     * @param string $type
     * @return Invoice
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string 
     */
    public function getType()
    {
        return $this->type;
    }

   
    /**
     * Get number
     *
     * @return string 
     */
    public function getNumber()
    {
        return 'F'.str_pad($this->id,6,"0",STR_PAD_LEFT);
    }

    /**
     * Set account
     *
     * @param \Sf\UserBundle\Entity\User $account
     * @return Invoice
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
     * Set transaction
     *
     * @param \Sf\AdminBundle\Entity\Transaction $transaction
     * @return Invoice
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
     * Add productModels
     *
     * @param \Sf\AdminBundle\Entity\ProductModel $productModels
     * @return Invoice
     */
    public function addProductModel(\Sf\AdminBundle\Entity\ProductModel $productModels)
    {
        $this->productModels[] = $productModels;

        return $this;
    }

    /**
     * Remove productModels
     *
     * @param \Sf\AdminBundle\Entity\ProductModel $productModels
     */
    public function removeProductModel(\Sf\AdminBundle\Entity\ProductModel $productModels)
    {
        $this->productModels->removeElement($productModels);
    }

    /**
     * Get productModels
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getProductModels()
    {
        return $this->productModels;
    }

    /**
     * Set order
     *
     * @param \Sf\AdminBundle\Entity\Order $order
     * @return Invoice
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
