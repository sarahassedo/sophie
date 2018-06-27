<?php

namespace DI\PlatformBundle\Cart;

use DI\PlatformBundle\Entity\Product as BaseProduct;

class Product extends BaseProduct
{
    /**
     * @var int
     */
    protected $quantity;

    protected $locale;

    /**
     * @param BaseProduct $baseProduct
     * @return Product
     */
    public static function create(BaseProduct $baseProduct)
    {
        $product = new self();
        $product->id = $baseProduct->getId();
        $product->setDescriptionEn($baseProduct->getDescriptionEn())
            ->setDescriptionFr($baseProduct->getDescriptionFr())
            ->setImage($baseProduct->getImage())
            ->setNameEn($baseProduct->getNameEn())
            ->setNameFr($baseProduct->getNameFr())
            ->setPrice($baseProduct->getPrice());
        return $product;
    }

    /**
     * @param int $quantity
     * @return Product
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
        return $this;
    }

    /**
     * @return int
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * @param mixed $locale
     * @return Product
     */
    public function setLocale($locale)
    {
        $this->locale = $locale;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLocale()
    {
        return $this->locale;
    }

    public function getName()
    {
        $name = "";
        switch ($this->locale) {
            case 'en':
                $name = $this->getNameEn();
                break;
            case 'fr':
                $name = $this->getNameFr();
                break;
            default:
                $name = $this->getNameEn();
                break;
        }
        return $name;
    }

    public function getDescription()
    {
        $description = "";
        switch ($this->locale) {
            case 'en':
                $description = $this->getDescriptionEn();
                break;
            case 'fr':
                $description = $this->getDescriptionFr();
                break;
            default:
                $description = $this->getDescriptionEn();
                break;
        }
        return $description;
    }

}