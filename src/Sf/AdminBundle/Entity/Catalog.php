<?php

namespace Sf\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Translatable\Translatable;
use Symfony\Component\Filesystem\Filesystem;

/**
 * Catalog
 *
 * @ORM\Table(name="catalog")
 * @ORM\Entity()
 * @ORM\HasLifecycleCallbacks
 */
class Catalog implements Translatable
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
     * @ORM\Column(name="year", type="integer")
     */
    private $year;
    
    
    
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

    
    
    public function getYearLabel(){
        return $this->year.' - '.($this->year+1);
    }
    

     /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload()
    {
      
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
     * Set year
     *
     * @param integer $year
     * @return Catalog
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
     * Set fileUrl
     *
     * @param string $fileUrl
     * @return Catalog
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

   
}
