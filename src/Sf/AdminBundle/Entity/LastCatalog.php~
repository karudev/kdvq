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
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=64)
     */
    private $type;
  
    


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
    
   
    public function preUpload()
    {
        if($this->id !=null){
            $this->removeUpload();
        }
        
        if (null !== $this->file) {
            $this->fileUrl = uniqid() . '.' . $this->file->guessExtension();
        }
    }
    
  
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
       
        if ($this->file !=null && $fs->exists($this->getAbsolutePath($this->fileUrl))) {
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
     * Set type
     *
     * @param string $type
     * @return LastCatalog
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
}
