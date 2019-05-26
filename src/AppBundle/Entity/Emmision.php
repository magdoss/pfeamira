<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Emmision
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Table(name="emmision")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\EmmisionRepository")
 */
class Emmision
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
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255)
     */
    private $nom;
    /**
     * @var Image
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Image", mappedBy="emmision", cascade={"persist","remove"}, orphanRemoval=true)
     */
    private $image;


    /**
     * @ORM\ManyToOne(targetEntity="\AppBundle\Entity\Service")
     */
    private $service;

    /**
     * @var Lot
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Lot")
     */
    private $lot;

    /**
     * @var ArrayCollection
     */
    private $files;

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
                $image->setEmmision($this);
                unset($file);
            }
        }
    }


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set nom
     *
     * @param string $nom
     *
     * @return Emmision
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set image
     *
     * @param string $image
     *
     * @return Emmision
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
     * Set service
     *
     * @param string $service
     *
     * @return Emmision
     */
    public function setService($service)
    {
        $this->service = $service;

        return $this;
    }

    /**
     * Get service
     *
     * @return string
     */
    public function getService()
    {
        return $this->service;
    }
    /**
     * Constructor
     */



    /**
     * Add image
     *
     * @param \AppBundle\Entity\Image $image
     *
     * @return Emmision
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
     * Set lot
     *
     * @param \AppBundle\Entity\Lot $lot
     *
     * @return Emmision
     */
    public function setLot(\AppBundle\Entity\Lot $lot = null)
    {
        $this->lot = $lot;

        return $this;
    }

    /**
     * Get lot
     *
     * @return \AppBundle\Entity\Lot
     */
    public function getLot()
    {
        return $this->lot;
    }
}
