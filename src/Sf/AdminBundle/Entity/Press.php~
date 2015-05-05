<?php

namespace Sf\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Translatable\Translatable;
use Symfony\Component\Filesystem\Filesystem;
use Sf\AdminBundle\Service\FileManager;

/**
 * Press
 *
 * @ORM\Table(name="press")
 * @ORM\Entity()
 * @ORM\HasLifecycleCallbacks
 */
class Press implements Translatable
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
     * @ORM\Column(name="parution_title", type="string", length=128, nullable=true)
     */
    private $parutionTitle;
    
     /**
     * @var string
     * @Gedmo\Translatable
     * @ORM\Column(name="parution_subtitle", type="string", length=128, nullable=true)
     */
    private $parutionSubtitle;
    
   
    
     /**
     * @var string
     * @Gedmo\Translatable
     * @ORM\Column(name="text", type="string", nullable=true)
     */
    private $text;
    
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
    private $secondPicture;

    /**
     * @var string
     *
     * @ORM\Column(name="second_picture_url", type="string", length=128, nullable=true)
     */
    private $secondPictureUrl;

    
     /**
     * @var boolean
     * @ORM\Column(name="active", type="boolean")
     */
    private $active = true;
    
     /**
     *  @var \DateTime
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
    

    /**
     * Set active
     *
     * @param boolean $active
     * @return AboutUs
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
    
    
    public function preUpload()
    {
        if($this->id != null)
            $this->removeUpload();
        
        if (null !== $this->mainPicture) {
            $this->mainPictureUrl = uniqid() . '.' . $this->mainPicture->guessExtension();
            $this->hdPictureUrl  = 'hd_'.$this->mainPictureUrl;
        }
        if (null !== $this->secondPicture) {
            $this->secondPictureUrl = uniqid() . '.' . $this->secondPicture->guessExtension();
        }
    }
    
   
    public function upload()
    {   
      
        if ($this->mainPicture != null) {
            $ext = $this->mainPicture->guessExtension(); 
            $this->mainPicture->move($this->getUploadRootDir(), $this->hdPictureUrl);
             FileManager::resize($this->getUploadRootDir().'/'.$this->hdPictureUrl,$ext, null,517,$this->getUploadRootDir().'/'.$this->mainPictureUrl);
            unset($this->mainPicture);
        }
        if ($this->secondPicture != null) {
              $ext = $this->secondPicture->guessExtension(); 
            $this->secondPicture->move($this->getUploadRootDir(), $this->secondPictureUrl);
             FileManager::resize($this->getUploadRootDir().'/'.$this->secondPictureUrl,$ext, null,113);
            unset($this->secondPicture);
        }
    }
    
    /**
     * @ORM\PostRemove()
     */
    public function removeUpload()
    {

        $fs = new Filesystem();
        if ($this->mainPictureUrl != null && $this->mainPicture != null && $fs->exists($this->getAbsolutePath($this->mainPictureUrl))) {
            unlink($this->getAbsolutePath($this->mainPictureUrl));
        }
         if ($this->hdPictureUrl !=null && $this->hdPicture !=null && $fs->exists($this->getAbsolutePath($this->hdPictureUrl))) {
            unlink($this->getAbsolutePath($this->hdPictureUrl));
        }
        
        if ($this->secondPictureUrl !=null && $this->secondPicture !=null && $fs->exists($this->getAbsolutePath($this->secondPictureUrl))) {
            unlink($this->getAbsolutePath($this->secondPictureUrl));
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
        return 'uploads/press';
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
     * Get hdPicture
     *
     * @return object
     */
    public function getHdPicture()
    {
        return $this->hdPicture;
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
     * Get mainPicture
     *
     * @return object
     */
    public function getMainPicture()
    {
        return $this->mainPicture;
    }
    
      /**
     * Set secondPicture
     *
     * @param object $secondPicture
     */
    public function setSecondPicture($secondPicture)
    {
        $this->secondPicture = $secondPicture;
    }

    /**
     * Get secondPicture
     *
     * @return object
     */
    public function getSecondPicture()
    {
        return $this->secondPicture;
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
     * Set parutionTitle
     *
     * @param string $parutionTitle
     * @return Press
     */
    public function setParutionTitle($parutionTitle)
    {
        $this->parutionTitle = $parutionTitle;

        return $this;
    }

    /**
     * Get parutionTitle
     *
     * @return string 
     */
    public function getParutionTitle()
    {
        return $this->parutionTitle;
    }

    /**
     * Set parutionSubtitle
     *
     * @param string $parutionSubtitle
     * @return Press
     */
    public function setParutionSubtitle($parutionSubtitle)
    {
        $this->parutionSubtitle = $parutionSubtitle;

        return $this;
    }

    /**
     * Get parutionSubtitle
     *
     * @return string 
     */
    public function getParutionSubtitle()
    {
        return $this->parutionSubtitle;
    }

    

    /**
     * Set mainPictureUrl
     *
     * @param string $mainPictureUrl
     * @return Press
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
     * Set secondPictureUrl
     *
     * @param string $secondPictureUrl
     * @return Press
     */
    public function setSecondPictureUrl($secondPictureUrl)
    {
        $this->secondPictureUrl = $secondPictureUrl;

        return $this;
    }

    /**
     * Get secondPictureUrl
     *
     * @return string 
     */
    public function getSecondPictureUrl()
    {
        return $this->secondPictureUrl;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Press
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
     * @return Press
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
     * Set hdPictureUrl
     *
     * @param string $hdPictureUrl
     * @return Press
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
     * Set text
     *
     * @param string $text
     * @return Press
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
}
