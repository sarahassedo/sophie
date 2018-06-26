<?php

namespace DI\PlatformBundle\Cart;

use DI\PlatformBundle\Entity\Product as BaseProduct;

class Product extends BaseProduct
{
    /**
     * @var int
     */
    protected $quantity;

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

}