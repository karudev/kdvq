<?php

namespace Sf\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Filesystem\Filesystem;
use Sf\AdminBundle\Service\FileManager;

/**
 * Carrousel
 *
 * @ORM\Table(name="carrousel")
 * @ORM\Entity()
 * @ORM\HasLifecycleCallbacks
 */
class Carrousel
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
     *
     * @Assert\Image(maxSize="8000000")
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
          //  $ext = $this->picture->guessExtension();
            $this->picture->move($this->getUploadRootDir(), $this->pictureUrl);
          //  FileManager::resize($this->getUploadRootDir().'/'.$this->pictureUrl,$ext, null,330);
            unset($this->picture);
        }
        
        
    }
    
    
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
        return 'uploads/carrousel';
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
     * Set pictureUrl
     *
     * @param string $pictureUrl
     * @return Carrousel
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
     * @return Carrousel
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
     * @return Carrousel
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
}
