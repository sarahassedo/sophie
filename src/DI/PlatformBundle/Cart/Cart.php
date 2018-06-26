<?php

namespace DI\PlatformBundle\Cart;


use DI\PlatformBundle\Entity\Product as BaseProduct;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\Session;

class Cart
{
    /** @var Cart */
    protected static $instance;

    protected $products;

    /** @var EntityManagerInterface  */
    protected $entityManager;

    protected function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->products = [];
    }

    public static function getInstance(EntityManagerInterface $entityManager = null)
    {
        if(empty(static::$instance)) {
            if (empty($entityManager)) {
                throw new \InvalidArgumentException("Must provide entity manager");
            }
            static::$instance = new static($entityManager);
            static::$instance->load();
        }
        return static::$instance;
    }

    public function addProduct(BaseProduct $product, $quantity = 1)
    {
        $productId = $product->getId();
        if($this->hasProduct($product)) {
            $previousQuantity = $this->products[$productId];
            $quantity = $previousQuantity + $quantity;
        }
        $this->products[$productId] = $quantity;
        $this->persist();
    }

    /**
     * @return array
     */
    public function getContents()
    {
        $contents = [];
        foreach ($this->products as $productId => $quantity) {
            $product = $this->getProduct($productId);
            if (!empty($product)) {
                $product->setQuantity($quantity);
                $contents[] = $product;
            }
        }
        return $contents;
    }

    public function removeAll()
    {
        $this->products = [];
        $this->persist();
        return $this;
    }

    public function getTotalPrice()
    {
        $total = 0;
        foreach ($this->getContents() as $product) {
            $linePrice = $product->getPrice() * $product->getQuantity();
            $total += $linePrice;
        }
        return $total;
    }

    protected function hasProduct(BaseProduct $product)
    {
        $productId = $product->getId();
        foreach (array_keys($this->products) as $id) {
            if($productId == $id) {
                return true;
            }
        }
        return false;
    }

    protected function getProduct($id)
    {
        $baseProduct = $this->entityManager->getRepository(BaseProduct::class)
            ->find($id);
        $cartProduct = null;
        if (!empty($baseProduct)) {
            $cartProduct = Product::create($baseProduct);
        }
        return $cartProduct;
    }

    protected function persist()
    {
        $session = new Session();

        $serialized = serialize($this->products);
        $session->set('cart', $serialized);
        return $this;
    }

    protected function load()
    {
        $session = new Session();

        $serialized = $session->get('cart');
        if (!empty($serialized)) {
            $this->products = unserialize($serialized);
        }
        return $this;
    }
}