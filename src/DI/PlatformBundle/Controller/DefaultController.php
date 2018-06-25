<?php

namespace DI\PlatformBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {

        return $this->render('DIPlatformBundle:Default:index.html.twig');
    }

    public function eshopAction()
    {
        return $this->render('DIPlatformBundle:Default:eshop.html.twig');

    }
}
