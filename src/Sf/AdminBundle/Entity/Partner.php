<?php

namespace Sf\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Translatable\Translatable;
use Symfony\Component\Filesystem\Filesystem;
use Sf\AdminBundle\Service\FileManager;

/**
 * Partner
 *
 * @ORM\Table(name="partner")
 * @ORM\Entity()
 * @ORM\HasLifecycleCallbacks
 */
class Partner implements Translatable
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
     * @ORM\Column(name="type", type="string", length=32)
     */
    private $type;

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
    
   
    
  
    
    

    
    
    public function preUpload()
    {
        if($this->id != null){
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
             FileManager::resize($this->getUploadRootDir().'/'.$this->pictureUrl,$ext, $this->type == 'club' ? 93 : 100);
            unset($this->picture);
        }
       
    }
    
    /**
     * @ORM\PostRemove()
     */
    public function removeUpload()
    {

        $fs = new Filesystem();
        if ($this->pictureUrl != null && $fs->exists($this->getAbsolutePath($this->pictureUrl))) {
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
        return 'uploads/partners';
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
     * Get Picture
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
     * @return Partner
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
     * Set type
     *
     * @param string $type
     * @return Partner
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
     * Set active
     *
     * @param boolean $active
     * @return Partner
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
     * Set pictureUrl
     *
     * @param string $pictureUrl
     * @return Partner
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
}
