<?php

namespace DI\PlatformBundle\Controller;

use DI\PlatformBundle\Cart\Cart;
use DI\PlatformBundle\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {

        return $this->render('DIPlatformBundle:Default:index.html.twig');
    }

    public function eshopAction()
    {
        $params = [
            'products' => $this->getProducts()
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

    protected function getCart()
    {
        $cart = Cart::getInstance($this->getDoctrine()->getManager());
        return $cart;
    }
}