<?php

namespace Sf\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Order
 *
 * @ORM\Table(name="order_")
 * @ORM\Entity(repositoryClass="Sf\AdminBundle\Entity\OrderRepository")
 */
class Order
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
     * @ORM\Column(name="order_date", type="datetime" , nullable = true)
     */
    private $orderDate;
    
     /**
     * @var \DateTime
     *
     * @ORM\Column(name="estimated_delivary_date", type="datetime", nullable = true)
     */
    private $estimatedDelivaryDate;

    
     /**
     * @ORM\ManyToOne(targetEntity="Sf\UserBundle\Entity\User", inversedBy="orders")
     * @ORM\JoinColumn(name="account_id", referencedColumnName="id")
     */
    private $account;
    
     /**
     * @ORM\ManyToOne(targetEntity="Transaction")
     * @ORM\JoinColumn(name="transaction_id", referencedColumnName="id", nullable = true)
     */
    private $transaction;

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
     * @ORM\Column(name="status", type="string", length=64)
     */
    private $status;
    
    /**
     * @var string
     * @ORM\Column(name="type", type="string", length=1)
     */
    private $type = 'C';
    
    /**
     * @var string
     * @ORM\Column(name="colisposte_number", type="string", length=128, nullable = true)
     */
    private $colisposteNumber;
    
     /**
     *
     *  @ORM\OneToMany(targetEntity="ProductModel", mappedBy="order" )
     */
    private $productModels;
    
     /**
     *
     *  @ORM\OneToMany(targetEntity="Mail", mappedBy="order")
     */
    private $mails;
    
  /**
     *
     *  @ORM\OneToMany(targetEntity="OrderStatus", mappedBy="order")
     */
    private $orderStatus;
    
    /**
     *
     *  @ORM\OneToOne(targetEntity="Invoice", mappedBy="order")
     */
    private $invoice;
   
   

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
    
   
    public function getNumber()
    {
        return $this->type.str_pad($this->id,6,"0",STR_PAD_LEFT);
    }

    /**
     * Set orderDate
     *
     * @param \DateTime $orderDate
     * @return Order
     */
    public function setOrderDate($orderDate)
    {
        $this->orderDate = $orderDate;

        return $this;
    }

    /**
     * Get orderDate
     *
     * @return \DateTime 
     */
    public function getOrderDate()
    {
        return $this->orderDate;
    }

    /**
     * Set estimatedDelivaryDate
     *
     * @param \DateTime $estimatedDelivaryDate
     * @return Order
     */
    public function setEstimatedDelivaryDate($estimatedDelivaryDate)
    {
        $this->estimatedDelivaryDate = $estimatedDelivaryDate;

        return $this;
    }

    /**
     * Get estimatedDelivaryDate
     *
     * @return \DateTime 
     */
    public function getEstimatedDelivaryDate()
    {
        return $this->estimatedDelivaryDate;
    }

    /**
     * Set tva
     *
     * @param float $tva
     * @return Order
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
     * @return Order
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
     * Set account
     *
     * @param \Sf\UserBundle\Entity\User $account
     * @return Order
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
     * @return Order
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
     * Set amountHt
     *
     * @param float $amountHt
     * @return Order
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
     * @return Order
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
     * Set titleAddress
     *
     * @param string $titleAddress
     * @return Order
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
     * @return Order
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
     * @return Order
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
     * @return Order
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
     * @return Order
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
     * @return Order
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
     * Set status
     *
     * @param string $status
     * @return Order
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
     * Set colisposteNumber
     *
     * @param string $colisposteNumber
     * @return Order
     */
    public function setColisposteNumber($colisposteNumber)
    {
        $this->colisposteNumber = $colisposteNumber;

        return $this;
    }

    /**
     * Get colisposteNumber
     *
     * @return string 
     */
    public function getColisposteNumber()
    {
        return $this->colisposteNumber;
    }

    /**
     * Set type
     *
     * @param string $type
     * @return Order
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
     * Constructor
     */
    public function __construct()
    {
        $this->productModels = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add productModels
     *
     * @param \Sf\AdminBundle\Entity\ProductModel $productModels
     * @return Order
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
     * Add mails
     *
     * @param \Sf\AdminBundle\Entity\Mail $mails
     * @return Order
     */
    public function addMail(\Sf\AdminBundle\Entity\Mail $mails)
    {
        $this->mails[] = $mails;

        return $this;
    }

    /**
     * Remove mails
     *
     * @param \Sf\AdminBundle\Entity\Mail $mails
     */
    public function removeMail(\Sf\AdminBundle\Entity\Mail $mails)
    {
        $this->mails->removeElement($mails);
    }

    /**
     * Get mails
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getMails()
    {
        return $this->mails;
    }

    /**
     * Add orderStatus
     *
     * @param \Sf\AdminBundle\Entity\OrderStatus $orderStatus
     * @return Order
     */
    public function addOrderStatus(\Sf\AdminBundle\Entity\OrderStatus $orderStatus)
    {
        $this->orderStatus[] = $orderStatus;

        return $this;
    }

    /**
     * Remove orderStatus
     *
     * @param \Sf\AdminBundle\Entity\OrderStatus $orderStatus
     */
    public function removeOrderStatus(\Sf\AdminBundle\Entity\OrderStatus $orderStatus)
    {
        $this->orderStatus->removeElement($orderStatus);
    }

    /**
     * Get orderStatus
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getOrderStatus()
    {
        return $this->orderStatus;
    }

    /**
     * Set invoice
     *
     * @param \Sf\AdminBundle\Entity\Invoice $invoice
     * @return Order
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
