<?php

namespace DI\PlatformBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Product
 *
 * @ORM\Table(name="recettes")
 * @ORM\Entity(repositoryClass="DI\PlatformBundle\Repository\ProductRepository")
 */
class Product
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
     * @ORM\Column(name="name_en", type="string", length=255)
     */
    private $name_en;

    /**
     * @var string
     *
     * @ORM\Column(name="name_fr", type="string", length=255)
     */
    private $name_fr;

    /**
     * @var int
     *
     * @ORM\Column(name="price", type="integer")
     */
    private $price;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=255)
     */
    private $image;

    /**
     * @var string
     *
     * @ORM\Column(name="description_en", type="string", length=500)
     */
    private $description_en;

    /**
     * @var string
     *
     * @ORM\Column(name="description_fr", type="string", length=500)
     */
    private $description_fr;


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
     * Set name_en
     *
     * @param string $name_en
     *
     * @return Product
     */
    public function setNameEn($name_en)
    {
        $this->name_en = $name_en;

        return $this;
    }

    /**
     * Get name_en
     *
     * @return string
     */
    public function getNameEn()
    {
        return $this->name_en;
    }

    /**
     * Set price
     *
     * @param integer $price
     *
     * @return Product
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return int
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set image
     *
     * @param string $image
     *
     * @return Product
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
     * Set description_en
     *
     * @param string $description_en
     *
     * @return Product
     */
    public function setDescriptionEn($description_en)
    {
        $this->description_en = $description_en;

        return $this;
    }

    /**
     * Get description_en
     *
     * @return string
     */
    public function getDescriptionEn()
    {
        return $this->description_en;
    }

    /**
     * @return string
     */
    public function getNameFr()
    {
        return $this->name_fr;
    }

    /**
     * @param string $name_fr
     * @return Product
     */
    public function setNameFr($name_fr)
    {
        $this->name_fr = $name_fr;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescriptionFr()
    {
        return $this->description_fr;
    }

    /**
     * @param string $description_fr
     * @return Product
     */
    public function setDescriptionFr($description_fr)
    {
        $this->description_fr = $description_fr;
        return $this;
    }
}

