<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ClientService
 *
 * @ORM\Table(name="inscription")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\InscriptionRepository")
 */
class Inscription
{
    /**
     * @ORM\Id()
     * @ORM\ManyToOne(targetEntity="\AppBundle\Entity\Client", inversedBy="inscription")
     * @ORM\JoinColumn(name="client_id", referencedColumnName="id", nullable=false)
     */
    private $client;

    /**
     * @ORM\Id()
     * @ORM\ManyToOne(targetEntity="\AppBundle\Entity\Service", inversedBy="inscription")
     * @ORM\JoinColumn(name="service_id", referencedColumnName="id", nullable=false)
     */
    private $service;

    /**
     * @var string
     *
     * @ORM\Column(name="score", type="integer", nullable=true)
     */
    private $score;

    /**
     * @var bool
     *
     * @ORM\Column(name="isWinner", type="boolean", nullable=true)
     */
    private $isWinner;

    public function __construct()
    {
        if ($this->service->getType() == "quiz") {
            $this->score = 0;
            $this->isWinner = false;
        }
    }


    /**
     * Set score
     *
     * @param string $score
     *
     * @return Inscription
     */
    public function setScore($score)
    {
        $this->score = $score;

        return $this;
    }

    /**
     * Get score
     *
     * @return string
     */
    public function getScore()
    {
        return $this->score;
    }

    /**
     * Set isWinner
     *
     * @param boolean $isWinner
     *
     * @return Inscription
     */
    public function setIsWinner($isWinner)
    {
        $this->isWinner = $isWinner;

        return $this;
    }

    /**
     * Get isWinner
     *
     * @return boolean
     */
    public function getIsWinner()
    {
        return $this->isWinner;
    }

    /**
     * Set client
     *
     * @param \AppBundle\Entity\Client $client
     *
     * @return Inscription
     */
    public function setClient(\AppBundle\Entity\Client $client)
    {
        $this->client = $client;

        return $this;
    }

    /**
     * Get client
     *
     * @return \AppBundle\Entity\Client
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * Set service
     *
     * @param \AppBundle\Entity\Service $service
     *
     * @return Inscription
     */
    public function setService(\AppBundle\Entity\Service $service)
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
}
