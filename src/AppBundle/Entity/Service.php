<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\Date;

/**
 *
 * @ORM\Entity
 * @ORM\Table(name="service")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ServiceRepository")
 */
class Service
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
     * @ORM\OneToOne(targetEntity="Article")
     * @ORM\JoinColumn(name="article_id", referencedColumnName="id", nullable=true, onDelete="CASCADE")
     */
    private $Article;
    /**
     * One Product has One Shipment.
     * @ORM\OneToOne(targetEntity="Quiz")
     * @ORM\JoinColumn(name="quiz_id", referencedColumnName="id", nullable=true, onDelete="CASCADE")
     */
    private $quiz;
    /**
     * One Product has One Shipment.
     * @ORM\OneToOne(targetEntity="Emmision")
     * @ORM\JoinColumn(name="emmision_id", referencedColumnName="id", nullable=true, onDelete="CASCADE")
     */
    private $emmision;

    /** @ORM\OneToMany(targetEntity="\AppBundle\Entity\Inscription", mappedBy="service") */
    protected $inscription;


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
     * Add inscription
     *
     * @param \AppBundle\Entity\Inscription $inscription
     *
     * @return Service
     */
    public function addInscription(\AppBundle\Entity\Inscription $inscription)
    {
        $this->inscription[] = $inscription;

        return $this;
    }

    /**
     * Remove inscription
     *
     * @param \AppBundle\Entity\Inscription $inscription
     */
    public function removeInscription(\AppBundle\Entity\Inscription $inscription)
    {
        $this->inscription->removeElement($inscription);
    }

    /**
     * Get inscription
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getInscription()
    {
        return $this->inscription;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->inscription = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set article.
     *
     * @param \AppBundle\Entity\Article|null $article
     *
     * @return Service
     */
    public function setArticle(\AppBundle\Entity\Article $article = null)
    {
        $this->Article = $article;

        return $this;
    }

    /**
     * Get article.
     *
     * @return \AppBundle\Entity\Article|null
     */
    public function getArticle()
    {
        return $this->Article;
    }

    /**
     * Set quiz.
     *
     * @param \AppBundle\Entity\Quiz|null $quiz
     *
     * @return Service
     */
    public function setQuiz(\AppBundle\Entity\Quiz $quiz = null)
    {
        $this->quiz = $quiz;

        return $this;
    }

    /**
     * Get quiz.
     *
     * @return \AppBundle\Entity\Quiz|null
     */
    public function getQuiz()
    {
        return $this->quiz;
    }

    /**
     * Set emmision.
     *
     * @param \AppBundle\Entity\Emmision|null $emmision
     *
     * @return Service
     */
    public function setEmmision(\AppBundle\Entity\Emmision $emmision = null)
    {
        $this->emmision = $emmision;

        return $this;
    }

    /**
     * Get emmision.
     *
     * @return \AppBundle\Entity\Emmision|null
     */
    public function getEmmision()
    {
        return $this->emmision;
    }
}
