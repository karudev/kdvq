<?php

namespace Sf\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Translatable\Translatable;

use Symfony\Component\Filesystem\Filesystem;

/**
 * ProductPicture
 *
 * @ORM\Table(name="product_picture")
 * @ORM\Entity()
 * @ORM\HasLifecycleCallbacks

 */
class ProductPicture
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
     * @Assert\Image(maxSize="6000000",mimeTypes={"image/jpeg","image/jpg","image/png","image/gif"})
     */
    private $pictureFile;

    /**
     * @var string
     *
     * @ORM\Column(name="picture_url", type="string", length=255, nullable=true)
     */
    private $pictureUrl;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     */
    private $updatedAt;

   

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
     * @return RubricPicture
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
    * Set pictureFile
    *
    * @param object $pictureFile
    */
    public function setPictureFile($pictureFile)
    {
    $this->pictureFile = $pictureFile;
    }

    /**
    * Get pictureFile
    *
    * @return object
    */
    public function getPictureFile()
    {
    return $this->pictureFile;
    }

    
    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return RubricPicture
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
     * @return RubricPicture
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
        if($this->id !=null ){
            $this->removeUpload();
        }
            
        if (null !== $this->pictureFile) {
            $this->pictureUrl = uniqid().'.'.$this->pictureFile->guessExtension();
        }
    }

   
    public function upload()
    {
        if (null === $this->pictureFile) {
            return;
        }

        $this->pictureFile->move($this->getUploadRootDir(), $this->pictureUrl);
        unset($this->pictureFile);
    }

    /**
     * @ORM\PostRemove()
     */
    public function removeUpload()
    {
       
        $fs = new Filesystem();
        if ($this->pictureFile != null && $fs->exists($this->getAbsolutePath($this->pictureFileUrl))) {
            unlink($this->getAbsolutePath($this->pictureFileUrl));
        }
    }

    public function getAbsolutePath()
    {
        return null === $this->pictureUrl ? null : $this->getUploadRootDir().'/'.$this->pictureUrl;
    }

    public function getWebPath()
    {
        return null === $this->pictureUrl ? null : $this->getUploadDir().'/'.$this->pictureUrl;
    }

    protected function getUploadRootDir()
    {
        return __DIR__.'/../../../../web/'.$this->getUploadDir();
    }

    protected function getUploadDir()
    {
        return 'uploads/product_pictures';
    }

    
}
