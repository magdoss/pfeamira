<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use AppBundle\Entity\Image;


/**
 * Article
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Table(name="article")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ArticleRepository")
 */
class Article
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    /**
     * @ORM\ManyToOne(targetEntity="\AppBundle\Entity\Service")
     */
    private $service;
    /**
     * @var string
     *
     * @ORM\Column(name="titre", type="string", length=255)
     */
    private $titre;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255)
     */
    private $description;

    /**
     * @var Image
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Image", mappedBy="article", cascade={"persist","remove"}, orphanRemoval=true)
     */
    private $image;
    /**
     * @var array
     *
     * @ORM\Column(name="jsonConfig", type="json_array", nullable=true)
     */
    private $jsonConfig;
    /**
     * @var ArrayCollection
     */
    private $files;

    /**
     * Get id
     *
     * @return int
     */

    public function __construct()
    {
        $this->image = new ArrayCollection();
    }

    /**
     * @ORM\PreFlush()
     */
    public function uploadImages()
    {
        if (is_array($this->files) || is_object($this->files)) {
            foreach ($this->files as $file) {
                /** @var UploadedFile $file */
                if (null === $file) {

                    return;
                }
                $image = new Image();
                $image->setFile($file);
                $image->upload();
                $image->setArticle($this);
                unset($file);
            }
        }
    }


    /**
     * Set service
     *
     * @param \AppBundle\Entity\Service $service
     *
     * @return Service
     */
    public function setService(\AppBundle\Entity\Service $service = null)
    {
        $this->service = $service;

        return $this;
    }

    /**
     * Get service
     *
     * @return \AppBundle\Entity\Service
     */
    public function getService()
    {
        return $this->service;
    }


    /**
     * @return ArrayCollection
     */
    public function getFiles()
    {
        return $this->files;
    }

    /**
     * @param ArrayCollection $files
     */
    public function setFiles($files)
    {
        $this->files = $files;
    }

    /**
     * Add image
     *
     * @param \AppBundle\Entity\Image $image
     *
     * @return Image
     */
    public function addImage(\AppBundle\Entity\Image $image)
    {
        $this->image[] = $image;

        return $this;
    }

    /**
     * Remove image
     *
     * @param \AppBundle\Entity\Image $image
     */
    public function removeImage(\AppBundle\Entity\Image $image)
    {
        $this->image->removeElement($image);
    }

    public function getId()
    {
        return $this->id;
    }

    /**
     * Set titre
     *
     * @param string $titre
     *
     * @return Article
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;

        return $this;
    }

    /**
     * Get titre
     *
     * @return string
     */
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Article
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set image
     *
     * @param string $image
     *
     * @return Article
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set jsonConfig
     *
     * @param array $jsonConfig
     *
     * @return Article
     */
    public function setJsonConfig($jsonConfig)
    {
        $this->jsonConfig = $jsonConfig;

        return $this;
    }

    /**
     * Get jsonConfig
     *
     * @return array
     */
    public function getJsonConfig()
    {
        return $this->jsonConfig;
    }
}

