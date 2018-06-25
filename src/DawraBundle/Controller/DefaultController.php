<?php

namespace DawraBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('DawraBundle:Default:index.html.twig');
    }
}
