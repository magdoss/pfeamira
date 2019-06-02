<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use AppBundle\Entity\Image;
use Symfony\Component\Validator\Constraints\Date;


/**
 * Article
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Table(name="article")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ArticleRepository")
 */
class Article
{


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
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="libelle", type="string", length=255)
     */
    private $libelle;


    /**
     *
     *
     * @ORM\ManyToOne(targetEntity="\AppBundle\Entity\ShortCode" )
     */

    private $shortCode;
    /**
     * @var string
     *
     * @ORM\Column(name="keyword", type="string")
     */
    private $keyword;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text",nullable=true)
     */
    private $description;
    /**
     * @var boolean
     *
     * @ORM\Column(name="is_active", type="boolean")
     */
    private $isActive;
    /**
     * @var Date
     *
     * @ORM\Column(name="date_creation", type="date")
     */
    private $dateCreation;
    /**
     * @var Date
     *
     * @ORM\Column(name="date_debut", type="date")
     */
    private $dateDebut;
    /**
     * @var string
     *
     * @ORM\Column(name="date_fin", type="date")
     */
    private $dateFin;
    /**
     * @var string
     *
     * @ORM\Column(name="price", type="float", nullable=true)
     */
    private $price;




    public function __construct()
    {
        $this->dateCreation = new \DateTime();
        $this->dateDebut = new \DateTime();
        $this->dateFin = new \DateTime();
        $this->image = new ArrayCollection();
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
     * Set libelle
     *
     * @param string $libelle
     *
     * @return Service
     */
    public function setLibelle($libelle)
    {
        $this->libelle = $libelle;

        return $this;
    }

    /**
     * Get libelle
     *
     * @return string
     */
    public function getLibelle()
    {
        return $this->libelle;
    }

//    /**
//     * Set type
//     *
//     * @param string $type
//     *
//     * @return Service
//     */
//    public function setType($type)
//    {
//        $this->type = $type;
//
//        return $this;
//    }
//
//    /**
//     * Get type
//     *
//     * @return string
//     */
//    public function getType()
//    {
//        return $this->type;
//    }

    /**
     * Set keyword
     *
     * @param string $keyword
     *
     * @return Service
     */
    public function setKeyword($keyword)
    {
        $this->keyword = $keyword;

        return $this;
    }

    /**
     * Get keyword
     *
     * @return string
     */
    public function getKeyword()
    {
        return $this->keyword;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Service
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
     * Set isActive
     *
     * @param boolean $isActive
     *
     * @return Service
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * Get isActive
     *
     * @return boolean
     */
    public function getIsActive()
    {
        return $this->isActive;
    }

    /**
     * Set dateCreation
     *
     * @param \DateTime $dateCreation
     *
     * @return Service
     */
    public function setDateCreation($dateCreation)
    {
        $this->dateCreation = $dateCreation;

        return $this;
    }

    /**
     * Get dateCreation
     *
     * @return \DateTime
     */
    public function getDateCreation()
    {
        return $this->dateCreation;
    }

    /**
     * Set dateDebut
     *
     * @param \DateTime $dateDebut
     *
     * @return Service
     */
    public function setDateDebut($dateDebut)
    {
        $this->dateDebut = $dateDebut;

        return $this;
    }

    /**
     * Get dateDebut
     *
     * @return \DateTime
     */
    public function getDateDebut()
    {
        return $this->dateDebut;
    }

    /**
     * Set dateFin
     *
     * @param \DateTime $dateFin
     *
     * @return Service
     */
    public function setDateFin($dateFin)
    {
        $this->dateFin = $dateFin;

        return $this;
    }

    /**
     * Get dateFin
     *
     * @return \DateTime
     */
    public function getDateFin()
    {
        return $this->dateFin;
    }

    /**
     * Set price
     *
     * @param float $price
     *
     * @return Service
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set shortCode
     *
     * @param \AppBundle\Entity\ShortCode $shortCode
     *
     * @return Service
     */
    public function setShortCode(\AppBundle\Entity\ShortCode $shortCode = null)
    {
        $this->shortCode = $shortCode;

        return $this;
    }

    /**
     * Get shortCode
     *
     * @return \AppBundle\Entity\ShortCode
     */
    public function getShortCode()
    {
        return $this->shortCode;
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

