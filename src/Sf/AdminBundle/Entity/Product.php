<?php

namespace Sf\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Translatable\Translatable;
use Symfony\Component\Filesystem\Filesystem;
use Sf\AdminBundle\Service\FileManager;

/**
 * Product
 *
 * @ORM\Table(name="product")
 * @ORM\Entity(repositoryClass="Sf\AdminBundle\Entity\ProductRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Product implements Translatable
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
     * @var string
     * @Gedmo\Translatable
     * @ORM\Column(name="subtitle", type="string", length=128, nullable=true)
     */
    private $subTitle;
    
    /**
     * @var string
     * @Gedmo\Translatable
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;
    
     /**
     * @var string
     * @Gedmo\Translatable
     * @ORM\Column(name="details", type="text", nullable=true)
     */
    private $details;
    
     /**
     * @var string
     * @Gedmo\Translatable
     * @ORM\Column(name="composition", type="text", nullable=true)
     */
    private $composition;
    
     /**
     * @var string
     * @Gedmo\Translatable
     * @ORM\Column(name="board_maintenance", type="text", nullable=true)
     */
    private $boardMaintenance;
    
     /**
     * @var string
     * @Gedmo\Translatable
     * @ORM\Column(name="youtube_id", type="string", length=128, nullable=true)
     */
    private $youtubeId;
    
 
    /**
     * @var float
     * 
     * @ORM\Column(name="priceHt", type="float")
     */
    private $priceHt;

    /**
     * @var float
     * 
     * @ORM\Column(name="tva", type="float")
     */
    private $tva = 0;
    
     /**
     * @var float
     * 
     * @ORM\Column(name="priceTtc", type="float")
     */
    private $priceTtc;
    
     /**
     * @var boolean
     * @ORM\Column(name="in_home", type="boolean")
     */
    private $inHome = false;
    

    
  
   
    /**
     *
     * @Assert\Image(maxSize="6000000")
     */
    private $mainPicture;

    /**
     * @var string
     *
     * @ORM\Column(name="main_picture_url", type="string", length=128, nullable=true)
     */
    private $mainPictureUrl;

    /**
     *
     * @Assert\Image(maxSize="6000000")
     */
    private $hdPicture;

    /**
     * @var string
     *
     * @ORM\Column(name="hd_picture_url", type="string", length=128, nullable=true)
     */
    private $hdPictureUrl;

    /**
     * @var string
     * @Gedmo\Translatable
     * @Gedmo\Slug(fields={"name"})
     * @ORM\Column(name="slug", unique=true, length=255)
     */
    private $slug;

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
     * @var boolean
     * @ORM\Column(name="active", type="boolean")
     */
    private $active = true;
    
    /**
     * @var boolean
     * @ORM\Column(name="deleted", type="boolean")
     */
    private $deleted = false;
    
   
    
     /**
     * @ORM\OneToMany(targetEntity="ProductModel",mappedBy="product")
     */
    private $productModels;
    
    
    
    /**
     *
     *  @ORM\ManyToMany(targetEntity="\Sf\AdminBundle\Entity\ProductPicture", cascade={"persist"})

     */
    private $productPictures;
    
    
    /**
     * @ORM\ManyToOne(targetEntity="Category")
     */
    private $category;
    


    
    
 
    public function preUpload()
    {
        if($this->id !=null){
            $this->removeUpload();
        }
       
        
        if (null !== $this->hdPicture) {
            $this->hdPictureUrl = uniqid() . '.' . $this->hdPicture->guessExtension();
           
        }
        if (null !== $this->mainPicture) {
            $this->mainPictureUrl = uniqid() . '.' . $this->mainPicture->guessExtension();
           
        }
    }

  
    public function upload()
    {
        if ($this->mainPicture != null) {
             //$ext = $this->hdPicture->guessExtension(); 
            $this->mainPicture->move($this->getUploadRootDir(), $this->mainPictureUrl);
           
          //  FileManager::resize($this->getUploadRootDir().'/'.$this->hdPictureUrl,$ext, 314,null,$this->getUploadRootDir().'/'.$this->mainPictureUrl);
            unset($this->mainPicture);
        }
           
      
        if ($this->hdPicture != null) {
             //$ext = $this->hdPicture->guessExtension(); 
            $this->hdPicture->move($this->getUploadRootDir(), $this->hdPictureUrl);
           
          //  FileManager::resize($this->getUploadRootDir().'/'.$this->hdPictureUrl,$ext, 314,null,$this->getUploadRootDir().'/'.$this->mainPictureUrl);
            unset($this->hdPicture);
        }
    }

    /**
     * @ORM\PostRemove()
     */
    public function removeUpload()
    {

        $fs = new Filesystem();
       
     
        if ($this->hdPicture !=null && $this->hdPictureUrl != null && $fs->exists($this->getAbsolutePath($this->hdPictureUrl))) {
            unlink($this->getAbsolutePath($this->hdPictureUrl));
        }
        if ($this->mainPicture !=null && $this->mainPictureUrl!=null && $fs->exists($this->getAbsolutePath($this->mainPictureUrl))) {
            unlink($this->getAbsolutePath($this->mainPictureUrl));
        }
    }

    public function getAbsolutePath($file)
    {
        return $this->getUploadRootDir() . '/' . $file;
    }

    /* public function getWebPath()
      {
      return $this->getUploadDir().'/'.$this->backgroundUrl;
      } */

    protected function getUploadRootDir()
    {
        return __DIR__ . '/../../../../web/' . $this->getUploadDir();
    }

    protected function getUploadDir()
    {
        return 'uploads/products';
    }




  
   
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->productModels = new \Doctrine\Common\Collections\ArrayCollection();
        $this->productPictures = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Product
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
     * Set subTitle
     *
     * @param string $subTitle
     * @return Product
     */
    public function setSubTitle($subTitle)
    {
        $this->subTitle = $subTitle;

        return $this;
    }

    /**
     * Get subTitle
     *
     * @return string 
     */
    public function getSubTitle()
    {
        return $this->subTitle;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Product
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

  
    /**
     * Set tva
     *
     * @param float $tva
     * @return Product
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
     * Get mainPicture
     *
     * @return object
     */
    public function getMainPicture()
    {
        return $this->mainPicture;
    }
     /**
     * Set mainPicture
     *
     * @param object $mainPicture
     */
    public function setMainPicture($mainPicture)
    {
        $this->mainPicture = $mainPicture;
    }
    
       /**
     * Get hdPicture
     *
     * @return object
     */
    public function getHdPicture()
    {
        return $this->hdPicture;
    }
     /**
     * Set hdPicture
     *
     * @param object $hdPicture
     */
    public function setHdPicture($hdPicture)
    {
        $this->hdPicture = $hdPicture;
    }
    
    /**
     * Set mainPictureUrl
     *
     * @param string $mainPictureUrl
     * @return Product
     */
    public function setMainPictureUrl($mainPictureUrl)
    {
        $this->mainPictureUrl = $mainPictureUrl;

        return $this;
    }

    /**
     * Get mainPictureUrl
     *
     * @return string 
     */
    public function getMainPictureUrl()
    {
        return $this->mainPictureUrl;
    }

    /**
     * Set hdPictureUrl
     *
     * @param string $hdPictureUrl
     * @return Product
     */
    public function setHdPictureUrl($hdPictureUrl)
    {
        $this->hdPictureUrl = $hdPictureUrl;

        return $this;
    }

    /**
     * Get hdPictureUrl
     *
     * @return string 
     */
    public function getHdPictureUrl()
    {
        return $this->hdPictureUrl;
    }

    /**
     * Set slug
     *
     * @param string $slug
     * @return Product
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
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Product
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
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     * @return Product
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime 
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set deletedAt
     *
     * @param \DateTime $deletedAt
     * @return Product
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
     * Set active
     *
     * @param boolean $active
     * @return Product
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
     * Set deleted
     *
     * @param boolean $deleted
     * @return Product
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
     * Add productModels
     *
     * @param \Sf\AdminBundle\Entity\ProductModel $productModels
     * @return Product
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
     * Add productPictures
     *
     * @param \Sf\AdminBundle\Entity\ProductPicture $productPictures
     * @return Product
     */
    public function addProductPicture(\Sf\AdminBundle\Entity\ProductPicture $productPictures)
    {
        $this->productPictures[] = $productPictures;

        return $this;
    }

    /**
     * Remove productPictures
     *
     * @param \Sf\AdminBundle\Entity\ProductPicture $productPictures
     */
    public function removeProductPicture(\Sf\AdminBundle\Entity\ProductPicture $productPictures)
    {
        $this->productPictures->removeElement($productPictures);
    }

    /**
     * Get productPictures
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getProductPictures()
    {
        return $this->productPictures;
    }

    /**
     * Set details
     *
     * @param string $details
     * @return Product
     */
    public function setDetails($details)
    {
        $this->details = $details;

        return $this;
    }

    /**
     * Get details
     *
     * @return string 
     */
    public function getDetails()
    {
        return $this->details;
    }

    /**
     * Set composition
     *
     * @param string $composition
     * @return Product
     */
    public function setComposition($composition)
    {
        $this->composition = $composition;

        return $this;
    }

    /**
     * Get composition
     *
     * @return string 
     */
    public function getComposition()
    {
        return $this->composition;
    }

    /**
     * Set boardMaintenance
     *
     * @param string $boardMaintenance
     * @return Product
     */
    public function setBoardMaintenance($boardMaintenance)
    {
        $this->boardMaintenance = $boardMaintenance;

        return $this;
    }

    /**
     * Get boardMaintenance
     *
     * @return string 
     */
    public function getBoardMaintenance()
    {
        return $this->boardMaintenance;
    }

    /**
     * Set youtubeId
     *
     * @param string $youtubeId
     * @return Product
     */
    public function setYoutubeId($youtubeId)
    {
        $this->youtubeId = $youtubeId;

        return $this;
    }

    /**
     * Get youtubeId
     *
     * @return string 
     */
    public function getYoutubeId()
    {
        return $this->youtubeId;
    }

    /**
     * Set category
     *
     * @param \Sf\AdminBundle\Entity\Category $category
     * @return Product
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
     * Set priceHt
     *
     * @param float $priceHt
     * @return Product
     */
    public function setPriceHt($priceHt)
    {
        $this->priceHt = $priceHt;

        return $this;
    }

    /**
     * Get priceHt
     *
     * @return float 
     */
    public function getPriceHt()
    {
        return $this->priceHt;
    }

    /**
     * Set priceTtc
     *
     * @param float $priceTtc
     * @return Product
     */
    public function setPriceTtc($priceTtc)
    {
        $this->priceTtc = $priceTtc;

        return $this;
    }

    /**
     * Get priceTtc
     *
     * @return float 
     */
    public function getPriceTtc()
    {
        return $this->priceTtc;
    }

    /**
     * Set inHome
     *
     * @param boolean $inHome
     * @return Product
     */
    public function setInHome($inHome)
    {
        $this->inHome = $inHome;

        return $this;
    }

    /**
     * Get inHome
     *
     * @return boolean 
     */
    public function getInHome()
    {
        return $this->inHome;
    }
}
