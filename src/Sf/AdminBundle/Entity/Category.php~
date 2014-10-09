<?php

namespace Sf\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Translatable\Translatable;
use Symfony\Component\Filesystem\Filesystem;

/**
 * Category
 *
 * @ORM\Table(name="category")
 * @ORM\Entity(repositoryClass="Sf\AdminBundle\Entity\CategoryRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Category implements Translatable
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
     * @Gedmo\Translatable
     * @ORM\Column(name="name", type="string", length=128)
     */
    private $name;
    
     /**
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="categories")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id", nullable=true)
     */
    private $category;
    
     /**
     * @ORM\OneToMany(targetEntity="Category",mappedBy = "category")
     */
    private $categories;
    
     /**
     * @var boolean
     * @ORM\Column(name="most_low_level", type="boolean")
     */
    private $mostLowLevel = false;
    
    /**
     * @var boolean
     * @ORM\Column(name="custom", type="boolean")
     */
    private $custom = false;
    
     /**
     * @var boolean
     * @ORM\Column(name="active", type="boolean")
     */
    private $active = true;
    
     /**
     * @var string
     * @Gedmo\Translatable
     * @Gedmo\Slug(fields={"name"})
     * @ORM\Column(name="slug", unique=true, length=255)
     */
    private $slug;
    
    


    public function getLabel(){
        return ($this->category!=null ? $this->getCategory()->getName() .', ' : ''). $this->name;
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
     * Set name
     *
     * @param string $name
     * @return Category
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set mostLowLevel
     *
     * @param boolean $mostLowLevel
     * @return Category
     */
    public function setMostLowLevel($mostLowLevel)
    {
        $this->mostLowLevel = $mostLowLevel;

        return $this;
    }

    /**
     * Get mostLowLevel
     *
     * @return boolean 
     */
    public function getMostLowLevel()
    {
        return $this->mostLowLevel;
    }

    /**
     * Set active
     *
     * @param boolean $active
     * @return Category
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get active
     *
     * @return boolean 
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Set category
     *
     * @param \Sf\AdminBundle\Entity\Category $category
     * @return Category
     */
    public function setCategory(\Sf\AdminBundle\Entity\Category $category = null)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \Sf\AdminBundle\Entity\Category 
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set custom
     *
     * @param boolean $custom
     * @return Category
     */
    public function setCustom($custom)
    {
        $this->custom = $custom;

        return $this;
    }

    /**
     * Get custom
     *
     * @return boolean 
     */
    public function getCustom()
    {
        return $this->custom;
    }

    /**
     * Set slug
     *
     * @param string $slug
     * @return Category
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string 
     */
    public function getSlug()
    {
        return $this->slug;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->categories = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add categories
     *
     * @param \Sf\AdminBundle\Entity\Category $categories
     * @return Category
     */
    public function addCategory(\Sf\AdminBundle\Entity\Category $categories)
    {
        $this->categories[] = $categories;

        return $this;
    }

    /**
     * Remove categories
     *
     * @param \Sf\AdminBundle\Entity\Category $categories
     */
    public function removeCategory(\Sf\AdminBundle\Entity\Category $categories)
    {
        $this->categories->removeElement($categories);
    }

    /**
     * Get categories
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCategories()
    {
        return $this->categories;
    }
}
