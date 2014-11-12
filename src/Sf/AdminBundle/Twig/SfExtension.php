<?php

namespace Sf\AdminBundle\Twig;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\ORM\EntityManager;
use Sf\AdminBundle\Entity\Product;
use Sf\UserBundle\Entity\User;
use Sf\AdminBundle\Entity\Order;
use Sf\AdminBundle\Entity\Category;
class SfExtension extends \Twig_Extension {

    private $_em;
    private $_container;

    public function __construct(EntityManager $em, ContainerInterface $container) {
        $this->_em = $em;
        $this->_container = $container;
    }

    public function getFunctions() {
        return array(
            new \Twig_SimpleFunction('getStock', array($this, 'getStock')),
            new \Twig_SimpleFunction('getNbOrder', array($this, 'getNbOrder')),
            new \Twig_SimpleFunction('isBtoCenabled', array($this, 'isBtoCenabled')),
            new \Twig_SimpleFunction('isReadOnly', array($this, 'isReadOnly')),
            new \Twig_SimpleFunction('getAddress', array($this, 'getAddress')),
            new \Twig_SimpleFunction('getPrice', array($this, 'getPrice')),
            new \Twig_SimpleFunction('getTva', array($this, 'getTva')),
            new \Twig_SimpleFunction('getMails', array($this, 'getMails')),
            new \Twig_SimpleFunction('getProductModelsGroupByRef', array($this, 'getProductModelsGroupByRef')),
            new \Twig_SimpleFunction('getEntityName', array($this, 'getEntityName')),
            new \Twig_SimpleFunction('hasRole', array($this, 'hasRole')),
            new \Twig_SimpleFunction('haveShoppingCartHistory', array($this, 'haveShoppingCartHistory')),
            new \Twig_SimpleFunction('getCategories', array($this, 'getCategories'))
        );
    }

    public function getStock(Product $product, $label = false) {

        $stock = $this->_em->getRepository('SfAdminBundle:ProductModel')->getStock($product);

        if ($label) {
            return '<div class="label-' . ( $stock > 0 ? 'success' : 'danger') . ' badge">' . $stock . '</div>';
        }

        return $stock;
    }

    public function getNbOrder(User $user) {

        $nbOrder = $this->_em->getRepository('SfUserBundle:User')->getNbOrders($user);


        return $nbOrder;
    }

    public function getAddress(User $user, $type) {

        $address = $this->_em->getRepository('SfUserBundle:Address')->get($user, $type);


        return $address;
    }

    public function isBtoCenabled() {
        $btoc = $this->_em->getRepository('SfAdminBundle:Config')->findOneBy(array('name' => 'btoc'));

        return $btoc ? (bool) $btoc->getValue() : false;
    }

    public function isReadOnly(User $user = null) {

        $boolBtoC = $this->isBtoCenabled();

        $value = true;
        if ($user == null && $boolBtoC) {
            $value = false;
        } else {
            if ($user->hasRole('ROLE_SHOP')) {
                $value = false;
            } elseif (!$user->hasRole('ROLE_SHOP') && $boolBtoC) {
                $value = false;
            }
        }
        return $value;
    }

    public function getPrice(Product $product, User $user = null, $quantity = 1) {
        if ($user != null) {
            if ($user->hasRole('ROLE_SHOP')) {
                $ttc = $product->getSellerPrice() + $product->getTvaBtoB();
                return number_format($ttc * $quantity, 2, ',', ' ');
            }
        }
        $ttc = $product->getRecommendedRetailPrice() + $product->getTvaBtoC();
        return number_format($ttc  * $quantity, 2, ',', ' ');
    }
    
    public function getTva(Product $product, User $user = null, $quantity = 1) {
        if ($user != null) {
            if ($user->hasRole('ROLE_SHOP')) {
                return number_format($product->getTvaBtoB()  * $quantity, 2, ',', ' ');
            }
        }
        return number_format($product->getTvaBtoC()  * $quantity, 2, ',', ' ');
    }

    public function getMails(Order $order) {
        return $this->_em->getRepository('SfAdminBundle:Mail')->get($order);

    }
    public function getProductModelsGroupByRef(Order $order){
         return $this->_em->getRepository('SfAdminBundle:ProductModel')->getProductModelsGroupByRef($order);
    }
    public function getEntityName($entity,$id = null,$suffix = null){
        if($id == null){
            return null;
        }
         $entity =  $this->_em->getRepository('SfAdminBundle:'.ucfirst($entity))->find($id);
         return $entity->getName().' '.$suffix;
    }
    public function haveShoppingCartHistory(Order $order){
    
         $entity =  $this->_em->getRepository('SfAdminBundle:ShoppingCart')->findBy(array('order' => $order->getId()));
         return (bool) $entity;
    }
    
    public function hasRole(User $user = null,$role){
        if($user == null){
            return false;
        }
        
        if($user->hasRole($role)){
            return true;
        }  else {
         return false;   
        }
    }
     public function getCategories(Category $category){
         return $this->_em->getRepository('SfAdminBundle:Category')->findBy(array('category' => $category->getId(),'active' => true),array('position' => 'asc'));
    }

    public function getName() {
        return 'sf_extension';
    }

}
