<?php

namespace HomeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function indexAction()
    {
        
        if($this->get('security.context')->getToken()->getUser() != 'anon.'){
        return $this->render('HomeBundle:Default:index.html.twig');}else{
    return $this->redirectToRoute('home_login');
        }
    }
    public function homeloginAction()
    {
        return $this->render('HomeBundle:Default:homelogin.html.twig');
    }
    public function loginDawraAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery('SELECT s FROM DbBundle:Kesm s WHERE s.id < 8');
        $kesm = $query->getResult();  
        $dawraTadrib = $em->getRepository('DbBundle:DawraTadrib')->findAll();
        
        return $this->render('HomeBundle:Default:loginDawra.html.twig',array('type'=>$request->get('target'),'kesms'=>$kesm,'dawrats'=>$dawraTadrib));
    }
}
