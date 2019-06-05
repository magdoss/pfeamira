<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\Date;

/**
 * Quiz
 *
 * @ORM\Table(name="quiz")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\QuizRepository")
 */
class Quiz
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
     * @var Lot
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Lot")
     */
    private $lot;

    /**
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Question", mappedBy="quiz")
     *
     */
    private $questions;

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


    /**
     * Constructor
     */
    public function __construct()
    {

        $this->dateCreation = new \DateTime();
        $this->dateDebut = new \DateTime();
        $this->dateFin = new \DateTime();
        $this->lot = new \Doctrine\Common\Collections\ArrayCollection();
        $this->questions = new \Doctrine\Common\Collections\ArrayCollection();
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


    /**
     * Add question
     *
     * @param \AppBundle\Entity\Question $question
     *
     * @return Quiz
     */
    public function addQuestion(\AppBundle\Entity\Question $question)
    {
        $this->questions[] = $question;

        return $this;
    }

    /**
     * Remove question
     *
     * @param \AppBundle\Entity\Question $question
     */
    public function removeQuestion(\AppBundle\Entity\Question $question)
    {
        $this->questions->removeElement($question);
    }

    /**
     * Get questions
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getQuestions()
    {
        return $this->questions;
    }

    /**
     * Set keyword.
     *
     * @param string $keyword
     *
     * @return Quiz
     */
    public function setKeyword($keyword)
    {
        $this->keyword = $keyword;

        return $this;
    }

    /**
     * Get keyword.
     *
     * @return string
     */
    public function getKeyword()
    {
        return $this->keyword;
    }

    /**
     * Set description.
     *
     * @param string|null $description
     *
     * @return Quiz
     */
    public function setDescription($description = null)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description.
     *
     * @return string|null
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set isActive.
     *
     * @param bool $isActive
     *
     * @return Quiz
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * Get isActive.
     *
     * @return bool
     */
    public function getIsActive()
    {
        return $this->isActive;
    }

    /**
     * Set dateCreation.
     *
     * @param \DateTime $dateCreation
     *
     * @return Quiz
     */
    public function setDateCreation($dateCreation)
    {
        $this->dateCreation = $dateCreation;

        return $this;
    }

    /**
     * Get dateCreation.
     *
     * @return \DateTime
     */
    public function getDateCreation()
    {
        return $this->dateCreation;
    }

    /**
     * Set dateDebut.
     *
     * @param \DateTime $dateDebut
     *
     * @return Quiz
     */
    public function setDateDebut($dateDebut)
    {
        $this->dateDebut = $dateDebut;

        return $this;
    }

    /**
     * Get dateDebut.
     *
     * @return \DateTime
     */
    public function getDateDebut()
    {
        return $this->dateDebut;
    }

    /**
     * Set dateFin.
     *
     * @param \DateTime $dateFin
     *
     * @return Quiz
     */
    public function setDateFin($dateFin)
    {
        $this->dateFin = $dateFin;

        return $this;
    }

    /**
     * Get dateFin.
     *
     * @return \DateTime
     */
    public function getDateFin()
    {
        return $this->dateFin;
    }

    /**
     * Set price.
     *
     * @param float|null $price
     *
     * @return Quiz
     */
    public function setPrice($price = null)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price.
     *
     * @return float|null
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set shortCode.
     *
     * @param \AppBundle\Entity\ShortCode|null $shortCode
     *
     * @return Quiz
     */
    public function setShortCode(\AppBundle\Entity\ShortCode $shortCode = null)
    {
        $this->shortCode = $shortCode;

        return $this;
    }

    /**
     * Get shortCode.
     *
     * @return \AppBundle\Entity\ShortCode|null
     */
    public function getShortCode()
    {
        return $this->shortCode;
    }
}
