<?php

namespace ChefBundle\Controller;

use DbBundle\Entity\Chef;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Chef controller.
 *
 */
class ChefController extends Controller
{
    /**
     * Lists all chef entities.
     *
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $idUser = $this->getUser()->getId();
        $privilaige = $em->getRepository('DbBundle:Privilaige')->findOneById($idUser);      
        $chefs = NULL;
        if($privilaige->getIdJiha() == NULL){
            $chefs = $em->getRepository('DbBundle:Chef')->findBy(array('actif'=>1));
        }else{
            $chefs = $em->getRepository('DbBundle:Chef')->findBy(array('idJiha'=>$privilaige->getIdJiha(),'actif'=>1));
        }
        
        if($request->get('message')){
            return $this->render('ChefBundle:chef:index.html.twig', array(
                'chefs' => $chefs,
                'message' => $request->get('message')
            ));
        }else{
            return $this->render('ChefBundle:chef:index.html.twig', array(
            'chefs' => $chefs,
        ));
        }
        
    }

    /**
     * Creates a new chef entity.
     *
     */
    public function newAction(Request $request)
    {
        $chef = new Chef();
        $form = $this->createForm('DbBundle\Form\ChefType', $chef);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $chefA = $em->getRepository('DbBundle:Chef')->findOneBy(array('inscrit' =>$chef->getInscrit(),'actif'=>1));
            if($chefA == NULL){
            $em->persist($chef);
            $em->flush();
            return $this->redirectToRoute('chef_show', array('id' => $chef->getId(),'message' => array('text' => 'تمت الاضافة بنجاح !','type' => 'success','titre' => 'شكرا ')));
            }else{
                
                return $this->redirectToRoute('chef_new', array('message' => array('text' => 'القائد موجودب بقاعدة الينات !','type' => 'warning','titre' => 'تحذير ')));
            }
            
        }

        if($request->get('message')){
            return $this->render('ChefBundle:chef:new.html.twig', array(
            'chef' => $chef,
            'message' => $request->get('message'),
            'form' => $form->createView(),
        ));
        }
        return $this->render('ChefBundle:chef:new.html.twig', array(
            'chef' => $chef,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a chef entity.
     *
     */
    public function showAction(Request $request,Chef $chef)
    {
        $deleteForm = $this->createDeleteForm($chef);
        $em = $this->getDoctrine()->getManager();
        $tadrib = array();
        $deres = $em->getRepository('DbBundle:DeresDawra')->findBy(array('actif' => 1, 'idChef'=>$chef->getId() ));
        $itars = $em->getRepository('DbBundle:ItarDawra')->findBy(array('actif' => 1, 'idChef'=>$chef->getId() ));
        
        
        //var_dump($tadrib[1]['dawra']);die();
        if($request->get('message')){
            return $this->render('ChefBundle:chef:show.html.twig', array(
            
            'message' => $request->get('message'),
            'chef' => $chef,
            'deres' => $deres,
            'itars' => $itars,
            'delete_form' => $deleteForm->createView(),
        ));
        }
        return $this->render('ChefBundle:chef:show.html.twig', array(
            'chef' => $chef,
            'deres' => $deres,
            'itars' => $itars,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing chef entity.
     *
     */
    public function editAction(Request $request, Chef $chef)
    {
        $deleteForm = $this->createDeleteForm($chef);
        $editForm = $this->createForm('DbBundle\Form\ChefType', $chef);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            
            
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('chef_edit', array('id' => $chef->getId()));
        }

        return $this->render('ChefBundle:chef:edit.html.twig', array(
            'chef' => $chef,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    public function updateAction(Request $request)
    {
        
        $em = $this->getDoctrine()->getManager();
        $chefs = $em->getRepository('DbBundle:Chef')->findBy(array('actif' => 1));
        
        foreach ($chefs as $chef){
            if(strlen($chef->getCin()) < 8){
                $text = $chef->getCin();
                $J = 8 - strlen($chef->getCin());
                for($i=1 ; $i<= $J ; $i++){
                    $text = '0'.$text;
                }
                $chef->setCin($text);
                $em->merge($chef);
                $em->flush();
            }
           
        }
    
    }

    /**
     * Deletes a chef entity.
     *
     */
    public function deleteAction(Request $request, Chef $chef)
    {
//        $form = $this->createDeleteForm($chef);
//        $form->handleRequest($request);
//
//        if ($form->isSubmitted() && $form->isValid()) {
//            $em = $this->getDoctrine()->getManager();
//            $em->remove($chef);
//            $em->flush();
//        }
        $em = $this->getDoctrine()->getManager();
        $chef->setActif(0);
        $chef->setInscrit($chef->getInscrit()."SUPR");
        $em->merge($chef);
        $em->flush();
        return $this->redirectToRoute('chef_index',array('message' => array('text' => 'تمت المسح بنجاح !','type' => 'success','titre' => 'شكرا ')));
    }

    /**
     * Creates a form to delete a chef entity.
     *
     * @param Chef $chef The chef entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Chef $chef)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('chef_delete', array('id' => $chef->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
