<?php

namespace Sf\UserBundle\Entity;


use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Table(name="address")
 * @ORM\Entity(repositoryClass="Sf\UserBundle\Entity\AddressRepository")
 */
class Address
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

     /**
     * @var string
     * @ORM\Column(name="title", type="string", length=128, nullable=true)
     */
    private $title;
    
     /**
     * @var string
     * @ORM\Column(name="address", type="string", length=255,nullable=true)
     */
    private $address;
    
    /**
     * @var string
     * @ORM\Column(name="additional_address", type="string", length=255, nullable=true)
     */
    private $additionalAddress;
    
    /**
     * @var string
     * @ORM\Column(name="zip_code", type="string", length=32,nullable=true)
     */
    private $zipCode;
    
     /**
     * @var string
     * @ORM\Column(name="city", type="string", length=128,nullable=true)
     */
    private $city;
    
     /**
     * @var string
     * @ORM\Column(name="country", type="string", length=128,nullable=true)
     */
    private $country;
    
    /**
     * @var string
     * @ORM\Column(name="type", type="string", length=128)
     */
    private $type = 'shipping';
    
    /**
     *
     *  @ORM\ManyToOne(targetEntity="User" , inversedBy="addresses",cascade={"persist"})
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
     * Set title
     *
     * @param string $title
     * @return Address
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set address
     *
     * @param string $address
     * @return Address
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
     * @return Address
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
     * @return Address
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
     * @return Address
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
     * @return Address
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
     * @return Address
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
     * Set account
     *
     * @param \Sf\UserBundle\Entity\User $account
     * @return Address
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
}
