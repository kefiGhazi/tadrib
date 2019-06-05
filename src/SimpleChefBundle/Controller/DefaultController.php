<?php

namespace ChefBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('ChefBundle:Default:index.html.twig');
    }
}
