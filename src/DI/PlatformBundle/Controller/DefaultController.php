<?php

namespace DI\PlatformBundle\Controller;

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

    public function cartAction()
    {
//        $params = [
//            'products' => $this->getProducts()
//        ];
        return $this->render('DIPlatformBundle:Default:cart.html.twig');

    }

    public function testProductAction()
    {
        $product1 = new Product();
        $product1->setName('Macaron')
            ->setPrice(15)
            ->setDescription('French biscuits')
            ->setImage('paris-brest.jpg');
        $product2 = new Product();
        $product2->setName('Spring')
            ->setPrice(28)
            ->setDescription('French little biscuits')
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
}
