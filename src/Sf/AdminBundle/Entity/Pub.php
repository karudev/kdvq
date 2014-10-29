<?php

namespace Sf\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

use Symfony\Component\Filesystem\Filesystem;
use Sf\AdminBundle\Service\FileManager;

/**
 * Pub
 *
 * @ORM\Table(name="pub")
 * @ORM\Entity()
 * @ORM\HasLifecycleCallbacks
 */
class Pub
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
     * @ORM\Column(name="title", type="string", length=128, nullable=true)
     */
    private $title;
    
    /**
     * @var string
     * @ORM\Column(name="link", type="string", length=128, nullable=true)
     */
    private $link;

  
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
     * @var boolean
     * @ORM\Column(name="active", type="boolean")
     */
    private $active = true;
    
    /**
     * @var boolean
     * @ORM\Column(name="position", type="integer")
     */
    private $position = 0;
    
    
   
    
  
    
    
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
      $this->updatedAt = new \DateTime();
    }


    
  
    public function preUpload()
    {
        if($this->id == null){
            $this->removeUpload();
        }
        if (null !== $this->picture) {
            $this->pictureUrl = uniqid() . '.' . $this->picture->guessExtension();
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
        
        
    }
    
    /**
     * @ORM\PostRemove()
     */
    public function removeUpload()
    {

        $fs = new Filesystem();
        if ($this->picture !=null && $this->pictureUrl != null && $fs->exists($this->getAbsolutePath($this->pictureUrl))) {
            unlink($this->getAbsolutePath($this->pictureUrl));
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
        return 'uploads/pubs';
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
     * @return Pub
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
     * Set link
     *
     * @param string $link
     * @return Pub
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
     * Set pictureUrl
     *
     * @param string $pictureUrl
     * @return Pub
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
     * @return Pub
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
     * Set position
     *
     * @param integer $position
     * @return Pub
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * Get position
     *
     * @return integer 
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Pub
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
     * @return Pub
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
}
