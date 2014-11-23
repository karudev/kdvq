<?php

namespace Sf\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Translatable\Translatable;
use Symfony\Component\Filesystem\Filesystem;


/**
 * Brand
 *
 * @ORM\Table(name="brand")
 * @ORM\Entity()
 * @ORM\HasLifecycleCallbacks
 */
class Brand implements Translatable {

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
     * @ORM\Column(name="subtitle", type="string", length=128)
     */
    private $subtitle;
    
      /**
     * @var string
     * @Gedmo\Translatable
     * @ORM\Column(name="text", type="text")
     */
    private $text;
    
      /**
     * @var string
     * @Gedmo\Translatable
     * @ORM\Column(name="text2", type="text")
     */
    private $text2;

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
    private $textPicture;

    /**
     * @var string
     *
     * @ORM\Column(name="text_picture_url", type="string", length=128, nullable=true)
     */
    private $textPictureUrl;

    /**
     * @var string
     * @Gedmo\Translatable
     * @ORM\Column(name="title2", type="string", length=128)
     */
    private $title2;

    /**
     * @var string
     * @Gedmo\Translatable
     * @ORM\Column(name="sub_title2", type="string", length=128)
     */
    private $subtitle2;

    /**
     *
     * @Assert\Image(maxSize="6000000")
     */
    private $picture2;

    /**
     * @var string
     *
     * @ORM\Column(name="picture2_url", type="string", length=128, nullable=true)
     */
    private $picture2Url;

    /**
     *
     * @Assert\Image(maxSize="6000000")
     */
    private $textPicture2;

    /**
     * @var string
     *
     * @ORM\Column(name="text_picture2_url", type="string", length=128, nullable=true)
     */
    private $textPicture2Url;

    /**
     *
     * @Assert\Image(maxSize="6000000")
     */
    private $centerPicture;

    /**
     * @var string
     *
     * @ORM\Column(name="center_picture_url", type="string", length=128, nullable=true)
     */
    private $centerPictureUrl;

    /**
     * @var boolean
     * @ORM\Column(name="active", type="boolean")
     */
    private $active = true;

    public function preUpload() {
        if ($this->id != null) {
            $this->removeUpload();
        }
        if (null !== $this->picture) {
            $this->pictureUrl = uniqid() . '.' . $this->picture->guessExtension();
        }
        if (null !== $this->picture2) {
            $this->picture2Url = uniqid() . '.' . $this->picture2->guessExtension();
        }

        if (null !== $this->textPicture) {
            $this->textPictureUrl = uniqid() . '.' . $this->textPicture->guessExtension();
        }
        if (null !== $this->textPicture2) {
            $this->textPicture2Url = uniqid() . '.' . $this->textPicture2->guessExtension();
        }


        if (null !== $this->centerPicture) {
            $this->centerPictureUrl = uniqid() . '.' . $this->centerPicture->guessExtension();
        }
    }

    public function upload() {

        if ($this->picture != null) {
            $this->picture->move($this->getUploadRootDir(), $this->pictureUrl);
            unset($this->picture);
        }
        if ($this->picture2 != null) {
            $this->picture2->move($this->getUploadRootDir(), $this->picture2Url);
            unset($this->picture2);
        }
        if ($this->textPicture != null) {
            $this->textPicture->move($this->getUploadRootDir(), $this->textPictureUrl);
            unset($this->textPicture);
        }
        if ($this->textPicture2 != null) {
            $this->textPicture2->move($this->getUploadRootDir(), $this->textPicture2Url);
            unset($this->textPicture2);
        }
        if ($this->centerPicture != null) {
            $this->centerPicture->move($this->getUploadRootDir(), $this->centerPictureUrl);
            unset($this->centerPicture);
        }
    }

    /**
     * @ORM\PostRemove()
     */
    public function removeUpload() {

        $fs = new Filesystem();
        if ($this->picture != null && $fs->exists($this->getAbsolutePath($this->pictureUrl))) {
            unlink($this->getAbsolutePath($this->pictureUrl));
        }
        if ($this->picture2 != null && $fs->exists($this->getAbsolutePath($this->picture2Url))) {
            unlink($this->getAbsolutePath($this->picture2Url));
        }
        if ($this->textPicture != null && $fs->exists($this->getAbsolutePath($this->textPictureUrl))) {
            unlink($this->getAbsolutePath($this->textPictureUrl));
        }
        if ($this->textPicture2 != null && $fs->exists($this->getAbsolutePath($this->textPicture2Url))) {
            unlink($this->getAbsolutePath($this->textPicture2Url));
        }
        if ($this->centerPicture != null && $fs->exists($this->getAbsolutePath($this->centerPictureUrl))) {
            unlink($this->getAbsolutePath($this->centerPictureUrl));
        }
    }

    public function getAbsolutePath($file) {
        return $this->getUploadRootDir() . '/' . $file;
    }

    /* public function getWebPath()
      {
      return $this->getUploadDir().'/'.$this->backgroundUrl;
      } */

    protected function getUploadRootDir() {
        return __DIR__ . '/../../../../web/' . $this->getUploadDir();
    }

    protected function getUploadDir() {
        return 'uploads/brand';
    }

    /**
     * Set picture
     *
     * @param object $picture
     */
    public function setPicture($picture) {
        $this->picture = $picture;
    }

    /**
     * Get Picture
     *
     * @return object
     */
    public function getPicture() {
        return $this->picture;
    }
    
    /**
     * Set picture2
     *
     * @param object $picture2
     */
    public function setPicture2($picture2) {
        $this->picture2 = $picture2;
    }

    /**
     * Get Picture2
     *
     * @return object
     */
    public function getPicture2() {
        return $this->picture2;
    }
    
    /**
     * Set textPicture
     *
     * @param object $textPicture
     */
    public function setTextPicture($textPicture) {
        $this->textPicture = $textPicture;
    }

    /**
     * Get textPicture
     *
     * @return object
     */
    public function getTextPicture() {
        return $this->textPicture;
    }
    
    /**
     * Set textPicture2
     *
     * @param object $textPicture2
     */
    public function setTextPicture2($textPicture2) {
        $this->textPicture2 = $textPicture2;
    }

    /**
     * Get textPicture2
     *
     * @return object
     */
    public function getTextPicture2() {
        return $this->textPicture2;
    }
    
    /**
     * Set centerPicture
     *
     * @param object $centerPicture
     */
    public function setCenterPicture($centerPicture) {
        $this->centerPicture = $centerPicture;
    }

    /**
     * Get centerPicture
     *
     * @return object
     */
    public function getCenterPicture() {
        return $this->centerPicture;
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return Partner
     */
    public function setTitle($title) {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle() {
        return $this->title;
    }

  

    /**
     * Set active
     *
     * @param boolean $active
     * @return Partner
     */
    public function setActive($active) {
        $this->active = $active;

        return $this;
    }

    /**
     * Get active
     *
     * @return boolean 
     */
    public function getActive() {
        return $this->active;
    }

    /**
     * Set pictureUrl
     *
     * @param string $pictureUrl
     * @return Partner
     */
    public function setPictureUrl($pictureUrl) {
        $this->pictureUrl = $pictureUrl;

        return $this;
    }

    /**
     * Get pictureUrl
     *
     * @return string 
     */
    public function getPictureUrl() {
        return $this->pictureUrl;
    }


    /**
     * Set subtitle
     *
     * @param string $subtitle
     * @return Brand
     */
    public function setSubtitle($subtitle)
    {
        $this->subtitle = $subtitle;

        return $this;
    }

    /**
     * Get subtitle
     *
     * @return string 
     */
    public function getSubtitle()
    {
        return $this->subtitle;
    }

    /**
     * Set textPictureUrl
     *
     * @param string $textPictureUrl
     * @return Brand
     */
    public function setTextPictureUrl($textPictureUrl)
    {
        $this->textPictureUrl = $textPictureUrl;

        return $this;
    }

    /**
     * Get textPictureUrl
     *
     * @return string 
     */
    public function getTextPictureUrl()
    {
        return $this->textPictureUrl;
    }

    /**
     * Set title2
     *
     * @param string $title2
     * @return Brand
     */
    public function setTitle2($title2)
    {
        $this->title2 = $title2;

        return $this;
    }

    /**
     * Get title2
     *
     * @return string 
     */
    public function getTitle2()
    {
        return $this->title2;
    }

    /**
     * Set subtitle2
     *
     * @param string $subtitle2
     * @return Brand
     */
    public function setSubtitle2($subtitle2)
    {
        $this->subtitle2 = $subtitle2;

        return $this;
    }

    /**
     * Get subtitle2
     *
     * @return string 
     */
    public function getSubtitle2()
    {
        return $this->subtitle2;
    }

    /**
     * Set picture2Url
     *
     * @param string $picture2Url
     * @return Brand
     */
    public function setPicture2Url($picture2Url)
    {
        $this->picture2Url = $picture2Url;

        return $this;
    }

    /**
     * Get picture2Url
     *
     * @return string 
     */
    public function getPicture2Url()
    {
        return $this->picture2Url;
    }

    /**
     * Set textPicture2Url
     *
     * @param string $textPicture2Url
     * @return Brand
     */
    public function setTextPicture2Url($textPicture2Url)
    {
        $this->textPicture2Url = $textPicture2Url;

        return $this;
    }

    /**
     * Get textPicture2Url
     *
     * @return string 
     */
    public function getTextPicture2Url()
    {
        return $this->textPicture2Url;
    }

    /**
     * Set centerPictureUrl
     *
     * @param string $centerPictureUrl
     * @return Brand
     */
    public function setCenterPictureUrl($centerPictureUrl)
    {
        $this->centerPictureUrl = $centerPictureUrl;

        return $this;
    }

    /**
     * Get centerPictureUrl
     *
     * @return string 
     */
    public function getCenterPictureUrl()
    {
        return $this->centerPictureUrl;
    }

    /**
     * Set text
     *
     * @param string $text
     * @return Brand
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
     * Set text2
     *
     * @param string $text2
     * @return Brand
     */
    public function setText2($text2)
    {
        $this->text2 = $text2;

        return $this;
    }

    /**
     * Get text2
     *
     * @return string 
     */
    public function getText2()
    {
        return $this->text2;
    }
}
