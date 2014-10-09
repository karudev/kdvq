<?php

namespace Sf\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Translatable\Translatable;
use Symfony\Component\Filesystem\Filesystem;
use Sf\AdminBundle\Service\FileManager;

/**
 * Actuality
 *
 * @ORM\Table(name="actuality")
 * @ORM\Entity(repositoryClass="Sf\AdminBundle\Entity\ActualityRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Actuality implements Translatable
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
     * @ORM\Column(name="title", type="string", length=128)
     */
    private $title;
    
    /**
     * @var string
     * @Gedmo\Translatable
     * @ORM\Column(name="link", type="string", length=128)
     */
    private $link;

   
   
    
     /**
     * @var string
     * @Gedmo\Translatable
     * @ORM\Column(name="text", type="string",nullable=true)
     */
    private $text;
    
     /**
     *
     * @Assert\Image(maxSize="6000000")
     */
    private $picture;

    /**
     * @var string
     *
     * @ORM\Column(name="picture_url", type="string", length=128, nullable=true)
     */
    private $pictureUrl;
    
     /**
     *
     * @Assert\Image(maxSize="6000000")
     */
    private $pictureHome;

    /**
     * @var string
     *
     * @ORM\Column(name="picture_home_url", type="string", length=128, nullable=true)
     */
    private $pictureHomeUrl;

    
     /**
     * @var boolean
     * @ORM\Column(name="active", type="boolean")
     */
    private $active = true;
    
    /**
     * @var boolean
     * @ORM\Column(name="in_home", type="boolean")
     */
    private $inHome = false;
    
    
   
    
  
    
    
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
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;
    
     /**
     * @var integer
     * @ORM\Column(name="year", type="integer")
     */
    private $year;
    
    

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
    public function updatedDateTime(){
      $this->updatedAt = new \dateTime();
    }


    
  
    public function preUpload()
    {
        if($this->id == null){
            $this->removeUpload();
        }
        if (null !== $this->picture) {
            $this->pictureUrl = uniqid() . '.' . $this->picture->guessExtension();
        }
         if (null !== $this->pictureHome) {
            $this->pictureHomeUrl = uniqid() . '.' . $this->pictureHome->guessExtension();
        }
    }
    
   
    public function upload()
    {   
      
        if ($this->picture != null) {
            $ext = $this->picture->guessExtension();
            $this->picture->move($this->getUploadRootDir(), $this->pictureUrl);
            FileManager::resize($this->getUploadRootDir().'/'.$this->pictureUrl,$ext, null,330);
            unset($this->picture);
        }
        
         if ($this->pictureHome != null) {
            $ext = $this->pictureHome->guessExtension();
            $this->pictureHome->move($this->getUploadRootDir(), $this->pictureHomeUrl);
            
            unset($this->pictureHome);
        }
    }
    
    /**
     * @ORM\PostRemove()
     */
    public function removeUpload()
    {

        $fs = new Filesystem();
        if ($fs->exists($this->getAbsolutePath($this->pictureUrl))) {
            unlink($this->getAbsolutePath($this->pictureUrl));
        }
        if ($fs->exists($this->getAbsolutePath($this->pictureHomeUrl))) {
            unlink($this->getAbsolutePath($this->pictureHomeUrl));
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
        return 'uploads/actualities';
    }
    
     /**
     * Set picture
     *
     * @param object $picture
     */
    public function setPicture($picture)
    {
        $this->picture = $picture;
    }

    /**
     * Get picture
     *
     * @return object
     */
    public function getPicture()
    {
        return $this->picture;
    }

      /**
     * Set pictureHome
     *
     * @param object $pictureHome
     */
    public function setPictureHome($pictureHome)
    {
        $this->pictureHome = $pictureHome;
    }

    /**
     * Get pictureHome
     *
     * @return object
     */
    public function getPictureHome()
    {
        return $this->pictureHome;
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
     * Set title
     *
     * @param string $title
     * @return Actuality
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
     * Set text
     *
     * @param string $text
     * @return Actuality
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * Get text
     *
     * @return string 
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * Set pictureUrl
     *
     * @param string $pictureUrl
     * @return Actuality
     */
    public function setPictureUrl($pictureUrl)
    {
        $this->pictureUrl = $pictureUrl;

        return $this;
    }

    /**
     * Get pictureUrl
     *
     * @return string 
     */
    public function getPictureUrl()
    {
        return $this->pictureUrl;
    }

    /**
     * Set active
     *
     * @param boolean $active
     * @return Actuality
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
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Actuality
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
     * @return Actuality
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
     * Set date
     *
     * @param \DateTime $date
     * @return Actuality
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
     * Set year
     *
     * @param integer $year
     * @return Actuality
     */
    public function setYear($year)
    {
        $this->year = $year;

        return $this;
    }

    /**
     * Get year
     *
     * @return integer 
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * Set link
     *
     * @param string $link
     * @return Actuality
     */
    public function setLink($link)
    {
        $this->link = $link;

        return $this;
    }

    /**
     * Get link
     *
     * @return string 
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * Set pictureHomeUrl
     *
     * @param string $pictureHomeUrl
     * @return Actuality
     */
    public function setPictureHomeUrl($pictureHomeUrl)
    {
        $this->pictureHomeUrl = $pictureHomeUrl;

        return $this;
    }

    /**
     * Get pictureHomeUrl
     *
     * @return string 
     */
    public function getPictureHomeUrl()
    {
        return $this->pictureHomeUrl;
    }

    /**
     * Set inHome
     *
     * @param boolean $inHome
     * @return Actuality
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
