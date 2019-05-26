<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Image
 *
 * @ORM\Table(name="image")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ImageRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Image
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
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;


    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Article", inversedBy="image")
     * @ORM\JoinColumn(name="article_id", nullable=true)
     */
    private $article;
    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Emmision", inversedBy="image")
     * @ORM\JoinColumn(name="emmision_id", nullable=true)
     */
    private $emmision;

    /**
     * @var  UploadedFile
     *
     */
    private $file;


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
     * Set Article
     *
     * @param \AppBundle\Entity\Article $offreVente
     *
     * @return Image
     */
    public function setArticle(\AppBundle\Entity\Article $article)
    {
        $article->getImage()->add($this);
        $this->article = $article;

        return $this;
    }

    /**
     * Get article
     *
     * @return \AppBundle\Entity\Article
     */
    public function getArticle()
    {
        return $this->article;
    }
    /**
     * Set Emmision
     *
     * @param \AppBundle\Entity\Emmision $emmision
     *
     * @return Image
     */
    public function setEmmision(\AppBundle\Entity\Emmision $emmision)
    {
        $emmision->getImage()->add($this);
        $this->emmision = $emmision;

        return $this;
    }

    /**
     * Get emmision
     *
     * @return \AppBundle\Entity\Emmision
     */
    public function getEmmision()
    {
        return $this->emmision;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Image
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @param mixed $file
     */
    public function setFile($file)
    {
        $this->file = $file;
    }

    public function getAbsolutePath()
    {
        return null === $this->name
            ? null
            : $this->getUploadRootDir().'/'.$this->name;
    }

    public function getWebPath()
    {
        return null === $this->name
            ? null
            : $this->getUploadDir().'/'.$this->name;
    }

    public function getUploadRootDir()
    {
        return __DIR__.'/../../../web/'.$this->getUploadDir();
    }

    protected function getUploadDir()
    {
        return 'uploads/images';
    }

    public function upload()
    {
        if (null === $this->getFile()) {
            return;
        }
        $filename = sha1(uniqid(mt_rand(), true));
        $this->name = $filename.'.'.$this->getFile()->guessExtension();
//        dump($this->getUploadRootDir());die;
        $this->getFile()->move($this->getUploadRootDir(), $this->name);
        $this->file = null;
    }

    /**
     * @ORM\PostRemove()
     */
    public function removeUpload()
    {
        if ($file = $this->getAbsolutePath()) {
            unlink($file);
        }
    }

    public function __toString()
    {
        return $this->name;
    }



}
