<?php

namespace DI\PlatformBundle\Controller;

use DI\PlatformBundle\Cart\Cart;
use DI\PlatformBundle\Entity\Product;
use DI\PlatformBundle\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{

    const HERO_PRODUCT_ID = 6;

    public function indexAction()
    {

        return $this->render('DIPlatformBundle:Default:index.html.twig');
    }

    public function eshopAction(Request $request)
    {
        $locale = $request->getLocale();
        $repo = $this->getDoctrine()->getRepository(Product::class);

        $heroProduct = $repo->find(static::HERO_PRODUCT_ID);
        $heroProduct = $this->getLocaleAwareProduct($heroProduct, $locale);
        $otherProducts = $this->getLocaleAwareProducts(
            $this->getProductsExcept($heroProduct), $locale);
        $params = [
            'heroProduct' => $heroProduct,
            'products' => $otherProducts
        ];
        return $this->render('DIPlatformBundle:Default:eshop.html.twig', $params);
    }


    public function addToCartAction($id)
    {
        $repo = $this->getDoctrine()->getRepository(Product::class);
        $product = $repo->find($id);
        if (!empty($product)) {
            $cart = $this->getCart();
            $cart->addProduct($product);
        }

        return $this->redirect($this->generateUrl('di_platform_cart'));
    }

    public function cartAction()
    {
        $cart = $this->getCart();
        $products = $cart->getContents();
        $total = $cart->getTotalPrice();
        $params = [
            'products' => $products,
            'totalPrice' => $total
        ];
        return $this->render('DIPlatformBundle:Default:cart.html.twig', $params);

    }

    public function getCartProducts()
    {
        $cart = $this->getCart();
        $products = $cart->getContents();
        return $products;
    }

    public function contactAction()
    {

        return $this->render('DIPlatformBundle:Default:contact.html.twig');
    }

    public function testProductAction()
    {
        $product1 = new Product();
        $product1->setNameEn('Macaron')
            ->setPrice(15)
            ->setDescriptionEn('French biscuits')
            ->setImage('paris-brest.jpg');
        $product2 = new Product();
        $product2->setNameEn('Spring')
            ->setPrice(28)
            ->setDescriptionEn('French little biscuits')
            ->setImage('Biscuit-breton.jpg');

        $params = [
            'products' => [
                $product1,
                $product2
            ]
        ];
        return $this->render('DIPlatformBundle:Default:product-test.html.twig', $params);
    }

    protected function getProducts()
    {
        $repo = $this->getDoctrine()->getRepository(Product::class);
        $products = $repo->findAll();
        return $products;
    }

    protected function getProductsExcept(Product $exception)
    {
        /** @var ProductRepository $repo */
        $repo = $this->getDoctrine()->getRepository(Product::class);
        $qb = $repo->createQueryBuilder('p')
            ->where('p.id != :productId')
            ->setParameter('productId', $exception->getId());

        $products = $qb->getQuery()->getResult();
        return $products;
    }

    protected function getCart()
    {
        $cart = Cart::getInstance($this->getDoctrine()->getManager());
        return $cart;
    }

    protected function getLocaleAwareProduct(Product $product, $locale)
    {
        $laProduct = \DI\PlatformBundle\Cart\Product::create($product)
            ->setLocale($locale);
        return $laProduct;
    }

    protected function getLocaleAwareProducts(array $products, $locale)
    {
        $laProducts = [];
        foreach ($products as $product) {
            $laProduct = $this->getLocaleAwareProduct($product, $locale);
            $laProducts[] = $laProduct;
        }
        return $laProducts;
    }
}