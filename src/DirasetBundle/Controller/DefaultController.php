<?php

namespace DirasetBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


class DefaultController extends Controller
{
    public function indexAction(Request $request)
    {
        
        if($request->get('msg')){
            return $this->render('DirasetBundle:Default:index.html.twig', array(
            'msg' => '1',
        ));
        }
    return $this->render('DirasetBundle:Default:index.html.twig');
    
    }
}
