<?php

namespace Sf\UserBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Table(name="account")
 * @ORM\Entity(repositoryClass="Sf\UserBundle\Entity\UserRepository")
 */
class User extends BaseUser {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     * @ORM\Column(name="firstname", type="string", length=128, nullable=true)
     */
    private $firstname;

    /**
     * @var string
     * @ORM\Column(name="lastname", type="string", length=128, nullable=true)
     */
    private $lastname;

    /**
     * @var string
     * @ORM\Column(name="phone", type="string", length=128, nullable=true)
     */
    private $phone;

    /**
     * @var string
     * @ORM\Column(name="status", type="string", length=64, nullable=true)
     */
    private $status;

    /**
     * @var string
     * @ORM\Column(name="civility", type="string", length=4, nullable=true)
     */
    private $civility;

    /**
     * @var string
     * @ORM\Column(name="trade_name", type="string", length=128, nullable=true)
     */
    private $tradeName;

    /**
     * @var string
     * @ORM\Column(name="social_name", type="string", length=128, nullable=true)
     */
    private $socialName;

    /**
     * @var string
     * @ORM\Column(name="siret", type="string", length=14, nullable=true)
     */
    private $siret;

    /**
     * @var string
     * @ORM\Column(name="background", type="text", nullable=true)
     */
    private $background;

    /**
     * @var string
     * @ORM\Column(name="country", type="string", length=128, nullable=true)
     */
    private $country;

    /**
     * @var string
     * @ORM\Column(name="auto_entrepreneur", type="boolean")
     */
    private $autoEntrepreneur = false;

    /**
     * @var string
     * @ORM\Column(name="tva", type="float")
     */
    private $tva = 0;

    /**
     *
     *  @ORM\OneToMany(targetEntity="Address", mappedBy="account" ,cascade={"persist"})
     */
    private $addresses;

    /**
     *
     *  @ORM\OneToMany(targetEntity="Sf\AdminBundle\Entity\Order", mappedBy="account" )
     */
    private $orders;

    public function __construct() {
        parent::__construct();
    }

    public function getFullname() {
        return $this->hasRole('ROLE_SHOP') ? $this->socialName : $this->firstname . ' ' . $this->lastname;
    }

    public function getLabel() {
        if ($this->hasRole('ROLE_SHOP')) {
            $label =  $this->socialName;
        } else {
            $label =  $this->firstname == null && $this->lastname == null ? $this->email : $this->firstname . ' ' . $this->lastname;
        }
        
        if(strlen($label) > 17 ){
            $label = substr($label,0, 17).'..';
        }
        return $label;
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
     * Set firstname
     *
     * @param string $firstname
     * @return User
     */
    public function setFirstname($firstname) {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get firstname
     *
     * @return string
     */
    public function getFirstname() {
        return $this->firstname;
    }

    /**
     * Set lastname
     *
     * @param string $lastname
     * @return User
     */
    public function setLastname($lastname) {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * Get lastname
     *
     * @return string
     */
    public function getLastname() {
        return $this->lastname;
    }

    /**
     * Set status
     *
     * @param string $status
     * @return User
     */
    public function setStatus($status) {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return string 
     */
    public function getStatus() {
        return $this->status;
    }

    /**
     * Set civility
     *
     * @param string $civility
     * @return User
     */
    public function setCivility($civility) {
        $this->civility = $civility;

        return $this;
    }

    /**
     * Get civility
     *
     * @return string 
     */
    public function getCivility() {
        return $this->civility;
    }

    /**
     * Set phone
     *
     * @param string $phone
     * @return User
     */
    public function setPhone($phone) {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return string 
     */
    public function getPhone() {
        return $this->phone;
    }

    public function setPassword($password) {
        if (false == empty($password)) {
            $this->password = $password;
        }
    }

    /**
     * Add addresses
     *
     * 
     * @return User
     */
    public function addAddress($addresses) {
        $this->addresses[] = $addresses;
        /* if ($addresses instanceof Address) {
          $this->addresses[] = $addresses;

          } elseif (is_array($addresses)) {
          \Doctrine\Common\Util\Debug::dump($this); die();
          $adress = new Address;
          $adress->setTitle($addresses['title'])
          ->setAccount($this)
          ->setAddress($addresses['address'])
          ->setAdditionalAddress($addresses['additionalAddress'])
          ->setZipCode($addresses['zipCode'])
          ->setCity($addresses['city'])
          ->setCountry($addresses['country'])
          ->setType($addresses['type']);



          //   \Doctrine\Common\Util\Debug::dump($adress); die();


          $this->addresses[] = $adress;
          /* foreach ($addresses as $key => $value) {

          if ($key == 0) {
          $value->setType('shipping');
          }
          if ($key == 1) {
          $value->setType('billing');
          }
          $this->addresses[] = $value;
          }
          }

         */
        return $this;
    }

    /**
     * Remove addresses
     *
     * @param \Sf\UserBundle\Entity\Address $addresses
     */
    public function removeAddress(\Sf\UserBundle\Entity\Address $addresses) {
        $this->addresses->removeElement($addresses);
    }

    /**
     * Get addresses
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getAddresses() {
        return $this->addresses;
    }

    /**
     * Add orders
     *
     * @param \Sf\AdminBundle\Entity\Order $orders
     * @return User
     */
    public function addOrder(\Sf\AdminBundle\Entity\Order $orders) {
        $this->orders[] = $orders;

        return $this;
    }

    /**
     * Remove orders
     *
     * @param \Sf\AdminBundle\Entity\Order $orders
     */
    public function removeOrder(\Sf\AdminBundle\Entity\Order $orders) {
        $this->orders->removeElement($orders);
    }

    /**
     * Get orders
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getOrders() {
        return $this->orders;
    }

    /**
     * Set tradeName
     *
     * @param string $tradeName
     * @return User
     */
    public function setTradeName($tradeName) {
        $this->tradeName = $tradeName;

        return $this;
    }

    /**
     * Get tradeName
     *
     * @return string 
     */
    public function getTradeName() {
        return $this->tradeName;
    }

    /**
     * Set socialName
     *
     * @param string $socialName
     * @return User
     */
    public function setSocialName($socialName) {
        $this->socialName = $socialName;

        return $this;
    }

    /**
     * Get socialName
     *
     * @return string 
     */
    public function getSocialName() {
        return $this->socialName;
    }

    /**
     * Set siret
     *
     * @param string $siret
     * @return User
     */
    public function setSiret($siret) {
        $this->siret = $siret;

        return $this;
    }

    /**
     * Get siret
     *
     * @return string 
     */
    public function getSiret() {
        return $this->siret;
    }

    /**
     * Set background
     *
     * @param string $background
     * @return User
     */
    public function setBackground($background) {
        $this->background = $background;

        return $this;
    }

    /**
     * Get background
     *
     * @return string 
     */
    public function getBackground() {
        return $this->background;
    }

    /**
     * Set country
     *
     * @param string $country
     * @return User
     */
    public function setCountry($country) {
        $this->country = $country;

        return $this;
    }

    /**
     * Get country
     *
     * @return string 
     */
    public function getCountry() {
        return $this->country;
    }

    /**
     * Set autoEntrepreneur
     *
     * @param boolean $autoEntrepreneur
     * @return User
     */
    public function setAutoEntrepreneur($autoEntrepreneur) {
        $this->autoEntrepreneur = $autoEntrepreneur;

        return $this;
    }

    /**
     * Get autoEntrepreneur
     *
     * @return boolean 
     */
    public function getAutoEntrepreneur() {
        return $this->autoEntrepreneur;
    }

    /**
     * Set tva
     *
     * @param float $tva
     * @return User
     */
    public function setTva($tva) {
        $this->tva = $tva;

        return $this;
    }

    /**
     * Get tva
     *
     * @return float 
     */
    public function getTva() {
        return $this->tva;
    }

}
