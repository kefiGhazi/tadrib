<?php

namespace DirasetBundle\Controller;

use DbBundle\Entity\DawraTadrib;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Responset;
use Symfony\Component\HttpFoundation\File\File;

/**
 * Inscrit controller.
 *
 */
class DawaratTadribController extends Controller
{
    /**
     * Lists all inscrit entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $dawras = $em->getRepository('DbBundle:DawraTadrib')->findAll();
        $markezs = $em->getRepository('DbBundle:MarkezTadrib')->findAll();
        $kesms = $em->getRepository('DbBundle:Kesm')->findAll();
        $query = $em->createQuery('SELECT s FROM DbBundle:AtributType s WHERE s.id <= 3  And s.id > 1');
        $dirassas = $query->getResult(); 
        return $this->render('DirasetBundle:dawaratTadrib:index.html.twig', array(
            'dawras' => $dawras,
            'markezs' => $markezs,
            'kesms' => $kesms,
            'dirassas' => $dirassas,
        ));
    }

    /**
     * Creates a new inscrit entity.
     *
     */
    public function newAction(Request $request)
    {
        
        
        $em = $this->getDoctrine()->getManager();
        $dawraTadrib = new DawraTadrib();
        $dawraTadrib->setNom($request->get('nom'));
        $dawraTadrib->setChef($request->get('chef'));
        $dawraTadrib->setLogin($request->get('login'));
        $dawraTadrib->setPsw($request->get('password'));
        $idAtributType = $em->getRepository('DbBundle:AtributType')->findOneBy(array('id' => $request->get('dirassa')));
        $dawraTadrib->setIdAtributType($idAtributType);
        $idKesm = $em->getRepository('DbBundle:Kesm')->findOneBy(array('id' => $request->get('kesm')));
        $dawraTadrib->setIdKesm($idKesm);
        $idMarkez = $em->getRepository('DbBundle:MarkezTadrib')->findOneBy(array('id' => $request->get('markez')));        
        $dawraTadrib->setIdMarkez($idMarkez);
        
        $em->persist($dawraTadrib);
        $em->flush();
        return $this->redirectToRoute('adminInscrit_dawra_index');
    }

    /**
     * Finds and displays a inscrit entity.
     *
     */
    public function showAction(Inscrit $inscrit)
    {
        $deleteForm = $this->createDeleteForm($inscrit);

        return $this->render('DirasetBundle:inscrit:show.html.twig', array(
            'inscrit' => $inscrit,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing inscrit entity.
     *
     */
    public function editAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $dawraTadrib = $em->getRepository('DbBundle:DawraTadrib')->findOneBy(array('id' => $request->get('id')));
        $dawraTadrib->setNom($request->get('nom'));
        $dawraTadrib->setChef($request->get('chef'));
        $dawraTadrib->setLogin($request->get('login'));
        $dawraTadrib->setPsw($request->get('password'));
        $idAtributType = $em->getRepository('DbBundle:AtributType')->findOneBy(array('id' => $request->get('dirassa')));
        $dawraTadrib->setIdAtributType($idAtributType);
        $idKesm = $em->getRepository('DbBundle:Kesm')->findOneBy(array('id' => $request->get('kesm')));
        $dawraTadrib->setIdKesm($idKesm);
        $idMarkez = $em->getRepository('DbBundle:MarkezTadrib')->findOneBy(array('id' => $request->get('markez')));        
        $dawraTadrib->setIdMarkez($idMarkez);
        
        $em->merge($dawraTadrib);
        $em->flush();
        return $this->redirectToRoute('adminInscrit_dawra_index');
    }
    public function newMarkezAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        
        $markez = new \DbBundle\Entity\MarkezTadrib();        
        $markez->setNom($request->get('nom'));
        
        $em->persist($markez);
        $em->flush();
        return $this->redirectToRoute('adminInscrit_dawra_index');
    }
    public function editMarkezAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        
        $markez = $em->getRepository('DbBundle:MarkezTadrib')->findOneBy(array('id' => $request->get('id')));        
        $markez->setNom($request->get('nom'));
        
        $em->merge($markez);
        $em->flush();
        return $this->redirectToRoute('adminInscrit_dawra_index');
    }
    public function editDirassaAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        
        $inscrit = $em->getRepository('DbBundle:Inscrit')->findOneBy(array('id' => $request->get('id')));        
        $Dr = $em->getRepository('DbBundle:AtributType')->findOneBy(array('id'=>$request->get('idDirassa')));
        $inscrit->setIdDirassa($Dr);       
        
        $em->merge($inscrit);
        $em->flush();
        if($request->get('target') == 'W'){
        return $this->redirectToRoute('adminInscrit_accepterW');
        
        }else{
            return $this->redirectToRoute('adminInscrit_accepterJ');
        }
    }

    /**
     * Deletes a inscrit entity.
     *
     */
    public function deleteAction(Request $request, Inscrit $inscrit)
    {
        $form = $this->createDeleteForm($inscrit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($inscrit);
            $em->flush();
        }

        return $this->redirectToRoute('inscrit_index');
    }

    /**
     * Creates a form to delete a inscrit entity.
     *
     * @param Inscrit $inscrit The inscrit entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Inscrit $inscrit)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('inscrit_delete', array('id' => $inscrit->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
