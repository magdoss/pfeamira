<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Lot
 *
 * @ORM\Table(name="lot")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\LotRepository")
 */
class Lot
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
     * @var string
     *
     * @ORM\Column(name="valeur", type="string", length=255)
     */
    private $valeur;

    /**
     * @var int
     *
     * @ORM\Column(name="nb_gagnant", type="integer", nullable=true)
     */
    private $nbGagnant;

    /**
     * @var int
     *
     * @ORM\Column(name="nb_restant", type="integer", nullable=true)
     */
    private $nbRestant;

    /**
     * @var Lot
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Quiz", inversedBy="lot")
     */
    private $quiz;
//    /**
//     * @var Lot
//     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Emmision", inversedBy="lot")
//     */
//    private $emission;

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
     * @return Lot
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
     * Set valeur
     *
     * @param string $valeur
     *
     * @return Lot
     */
    public function setValeur($valeur)
    {
        $this->valeur = $valeur;

        return $this;
    }

    /**
     * Get valeur
     *
     * @return string
     */
    public function getValeur()
    {
        return $this->valeur;
    }

    /**
     * Set nbGagnant
     *
     * @param integer $nbGagnant
     *
     * @return Lot
     */
    public function setNbGagnant($nbGagnant)
    {
        $this->nbGagnant = $nbGagnant;

        return $this;
    }

    /**
     * Get nbGagnant
     *
     * @return int
     */
    public function getNbGagnant()
    {
        return $this->nbGagnant;
    }

    /**
     * Set nbRestant
     *
     * @param integer $nbRestant
     *
     * @return Lot
     */
    public function setNbRestant($nbRestant)
    {
        $this->nbRestant = $nbRestant;

        return $this;
    }

    /**
     * Get nbRestant
     *
     * @return int
     */
    public function getNbRestant()
    {
        return $this->nbRestant;
    }

    /**
     * Set quiz
     *
     * @param \AppBundle\Entity\Lot $quiz
     *
     * @return Lot
     */
    public function setQuiz(\AppBundle\Entity\Lot $quiz = null)
    {
        $this->quiz = $quiz;

        return $this;
    }

    /**
     * Get quiz
     *
     * @return \AppBundle\Entity\Lot
     */
    public function getQuiz()
    {
        return $this->quiz;
    }

    /**
     * Set emission
     *
     * @param \AppBundle\Entity\Emmision $emission
     *
     * @return Lot
     */
    public function setEmission(\AppBundle\Entity\Emmision $emission = null)
    {
        $this->emission = $emission;

        return $this;
    }

    /**
     * Get emission
     *
     * @return \AppBundle\Entity\Emmision
     */
    public function getEmission()
    {
        return $this->emission;
    }
}
