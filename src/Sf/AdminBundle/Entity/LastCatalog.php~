<?php

namespace Sf\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Translatable\Translatable;
use Symfony\Component\Filesystem\Filesystem;

/**
 * LastCatalog
 *
 * @ORM\Table(name="last_catalog")
 * @ORM\Entity()
 * @ORM\HasLifecycleCallbacks
 */
class LastCatalog implements Translatable
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
     * @ORM\Column(name="text", type="string")
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
     * @Assert\File(maxSize="6000000",mimeTypes={"application/pdf"})
     */
    private $file;

    /**
     * @var string
     *
     * @ORM\Column(name="file_url", type="string", length=128, nullable=true)
     */
    private $fileUrl;

    
    
    
    

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
     * @return LastCatalog
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
     * @return LastCatalog
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
     * @return LastCatalog
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
     * Set fileUrl
     *
     * @param string $fileUrl
     * @return LastCatalog
     */
    public function setFileUrl($fileUrl)
    {
        $this->fileUrl = $fileUrl;

        return $this;
    }

    /**
     * Get fileUrl
     *
     * @return string 
     */
    public function getFileUrl()
    {
        return $this->fileUrl;
    }
    
     /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload()
    {
        if (null !== $this->picture) {
            $this->pictureUrl = uniqid() . '.' . $this->picture->guessExtension();
        }
        if (null !== $this->file) {
            $this->fileUrl = uniqid() . '.' . $this->file->guessExtension();
        }
    }
    
    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function upload()
    {   
      
        if ($this->picture != null) {
            $this->picture->move($this->getUploadRootDir(), $this->pictureUrl);
            unset($this->picture);
        }
        if ($this->file != null) {
            $this->file->move($this->getUploadRootDir(), $this->fileUrl);
            unset($this->file);
        }
    }
    
    /**
     * @ORM\PostRemove()
     */
    public function removeUpload()
    {

        $fs = new Filesystem();
        if ($fs->exists($this->getAbsolutePath($this->pictureUrl))) {
            unlink($this->picture);
        }
        if ($fs->exists($this->getAbsolutePath($this->fileUrl))) {
            unlink($this->file);
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
        return 'uploads/catalogs';
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
     * Set file
     *
     * @param object $file
     */
    public function setFile($file)
    {
        $this->file = $file;
    }

    /**
     * Get $file
     *
     * @return object
     */
    public function getFile()
    {
        return $this->file;
    }
}
