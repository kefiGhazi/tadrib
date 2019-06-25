<?php

namespace DawraBundle\Controller;

use DbBundle\Entity\Inscrit;
use DbBundle\Entity\Link;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Link controller.
 *
 */
class LinkController extends Controller
{
    /**
     * Lists all link entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $linksNumber = array();
        $links = $em->getRepository('DbBundle:Link')->findByActif(1);
        foreach ($links as $link){
            $result = $em->getRepository('DbBundle:Inscrit')->findBy(array('idLink'=>$link->getId()));
            if($result == null){
                $result = 0;
            }else{
                $result = count($result);
            }
            $linksNumber[$link->getId()] = $result;
        }

        return $this->render('DawraBundle:link:index.html.twig', array(
            'links' => $links,
            'linksNumber' => $linksNumber,
        ));
    }

    /**
     * Creates a new link entity.
     *
     */
    public function newAction(Request $request)
    {
        $link = new Link();
        $form = $this->createForm('DbBundle\Form\LinkType', $link);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($link);
            $em->flush();

            return $this->redirectToRoute('link_show', array('id' => $link->getId()));
        }

        return $this->render('DawraBundle:link:new.html.twig', array(
            'link' => $link,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a link entity.
     *
     */
    public function showAction(Link $link)
    {

        $form = $this->createForm('DbBundle\Form\LinkType', $link);

        return $this->render('DawraBundle:link:show.html.twig', array(
            'link' => $link,
            'form' => $form->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing link entity.
     *
     */
    public function editAction(Request $request, Link $link)
    {
        $deleteForm = $this->createDeleteForm($link);
        $editForm = $this->createForm('DbBundle\Form\LinkType', $link);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('link_edit', array('id' => $link->getId()));
        }

        return $this->render('DawraBundle:link:edit.html.twig', array(
            'link' => $link,
            'form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a link entity.
     *
     */
    public function deleteAction(Request $request, Link $link)
    {
       
            $em = $this->getDoctrine()->getManager();
            $link->setActif(0);
            $em->merge($link);
            $em->flush();
       

        return $this->redirectToRoute('link_index');
    }

    /**
     * Creates a form to delete a link entity.
     *
     * @param Link $link The link entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Link $link)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('link_delete', array('id' => $link->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
