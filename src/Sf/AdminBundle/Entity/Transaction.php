<?php

namespace Sf\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Transaction
 *
 * @ORM\Table(name="transaction")
 * @ORM\Entity(repositoryClass="Sf\AdminBundle\Entity\TransactionRepository")
 */
class Transaction
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
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

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
     *
     * @ORM\Column(name="currency", type="string", length=3)
     */
    private $currency;

    /**
     * @var string
     *
     * @ORM\Column(name="state", type="string", length=32)
     */
    private $state;

    /**
     * @var string
     *
     * @ORM\Column(name="token", type="string", length=255)
     */
    private $token;
    
     /**
     * @ORM\ManyToOne(targetEntity="Sf\UserBundle\Entity\User")
     * @ORM\JoinColumn(name="account_id", referencedColumnName="id")
     */
    private $account;

   
  
    


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
     * Set date
     *
     * @param \DateTime $date
     * @return Transaction
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime 
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set amountHt
     *
     * @param float $amountHt
     * @return Transaction
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
     * @return Transaction
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
     * Set currency
     *
     * @param string $currency
     * @return Transaction
     */
    public function setCurrency($currency)
    {
        $this->currency = $currency;

        return $this;
    }

    /**
     * Get currency
     *
     * @return string 
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * Set state
     *
     * @param string $state
     * @return Transaction
     */
    public function setState($state)
    {
        $this->state = $state;

        return $this;
    }

    /**
     * Get state
     *
     * @return string 
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * Set token
     *
     * @param string $token
     * @return Transaction
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
     * Set account
     *
     * @param \Sf\UserBundle\Entity\User $account
     * @return Transaction
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
     * Set tva
     *
     * @param float $tva
     * @return Transaction
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
     * @return Transaction
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
}
