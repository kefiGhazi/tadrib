<?php

namespace DirasetBundle\Controller;

use DbBundle\Entity\Inscrit;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Responset;
use Symfony\Component\HttpFoundation\File\File;

/**
 * Inscrit controller.
 *
 */
class InscritController extends Controller
{
    /**
     * Lists all inscrit entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $inscrits = $em->getRepository('DbBundle:Inscrit')->findAll();

        return $this->render('DirasetBundle:inscrit:index.html.twig', array(
            'inscrits' => $inscrits,
        ));
    }
    public function dawraAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        
        $D = $em->getRepository('DbBundle:DawraTadrib')->findOneBy(array('id'=>$request->get('dawra'),'psw'=>$request->get('psw'),'login'=>$request->get('nom')));
        $Dawrat = $em->getRepository('DbBundle:DawraTadrib')->findAll();
        
        if(count($D) == 0){
            return $this->render('HomeBundle:Default:Dawra.html.twig', array(
            'msg' => 'erreur',
            'dawrats' => $Dawrat,
        ));
        }
        
        $query = $em->createQuery('SELECT s FROM DbBundle:Inscrit s WHERE s.idDirassaA = '.$request->get('dawra'));
        $inscrits = $query->getResult(); 
        return $this->render('HomeBundle:Default:Dawra.html.twig', array(
            'inscrits' => $inscrits,
            'D' => $D,
        ));
    }
    public function kesmAction(Request $request)
    {
        
        
        $em = $this->getDoctrine()->getManager();
        
        $K = $em->getRepository('DbBundle:Kesm')->findOneBy(array('id'=>$request->get('kesm'),'psw'=>$request->get('psw')));
        $query = $em->createQuery('SELECT s FROM DbBundle:Kesm s WHERE s.id < 8');
        $kesm = $query->getResult();  
        if(count($K) == 0){
            return $this->render('HomeBundle:Default:kesm.html.twig', array(
            'msg' => 'erreur',
            'kesms' => $kesm,
        ));
        }
        
        $query = $em->createQuery('SELECT s FROM DbBundle:Inscrit s WHERE s.idKesm = '.$request->get('kesm'));
        $inscrits = $query->getResult(); 
        return $this->render('HomeBundle:Default:kesm.html.twig', array(
            'inscrits' => $inscrits,
            'k' => $K,
        ));
    }

    /**
     * Creates a new inscrit entity.
     *
     */
    public function newAction(Request $request)
    {
//        return $this->redirectToRoute('diraset_homepage');
         $em = $this->getDoctrine()->getManager();
        
        $inscrit = new Inscrit();
        
        
        
        $form = $this->createForm('DbBundle\Form\InscritType', $inscrit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                 //  ulpoad image
            $file = $inscrit->getImageCinFace();
            $fileName = md5(uniqid()).'.'.$file->guessExtension();
            $file->move(
                $this->getParameter('cin_directory'),
                $fileName
            );
            // end upload
            $inscrit->setImageCinFace($fileName);
            
            //  ulpoad image
            $file2 = $inscrit->getImageCinPile();
            $fileName2 = md5(uniqid()).'.'.$file2->guessExtension();
            $file2->move(
                $this->getParameter('cin_directory'),
                $fileName2
            );
            // end upload
            $inscrit->setImageCinPile($fileName2);
            
            
            $lD = $em->getRepository('DbBundle:AtributType')->findOneBy(array('id'=>$request->get('lastDirassa')));
            $inscrit->setLastDirassa($lD);
            
            $Dr = $em->getRepository('DbBundle:AtributType')->findOneBy(array('id'=>$request->get('dirassa')));
            $inscrit->setIdDirassa($Dr);
            
            $Kesme = $em->getRepository('DbBundle:Kesm')->findOneBy(array('id'=>$request->get('kesm')));
            $inscrit->setIdKesm($Kesme);
            
            $em->persist($inscrit);
            $em->flush();

            return $this->redirectToRoute('inscrit_edit', array('id' => $inscrit->getId(),'msg'=>2));
            } catch (\Exception $ex) {
                 return $this->redirectToRoute('diraset_homepage', array('msg'=>1));
            }
           
        }
        
        
        if($request->get('cin') == NULL || $request->get('num')==null){
            return $this->redirectToRoute('diraset_homepage');
        }
        
        if ($request->get('cin')){$cin = $request->get('cin');}
        if ($request->get('num')){$num = $request->get('num');}
        if ($request->get('D')){$D = $request->get('D');}
        
        if($request->get('cin') && $request->get('num')){
            
        $query = $em->createQuery('SELECT s FROM DbBundle:Inscrit s WHERE s.cin = '.$cin.' AND s.numeroInscrit = '.$num);
        $VA = $query->getResult();            
           if(count($VA)){
              return $this->redirectToRoute('inscrit_edit', array('id' => $VA[0]->getId(),'msg'=>1));
           } 
        }
        
        
        $query = $em->createQuery('SELECT s FROM DbBundle:AtributType s WHERE s.id < 4 ');
        $VA = $query->getResult();
        $query = $em->createQuery('SELECT s FROM DbBundle:Kesm s WHERE s.id < 8 ');
        $Kesm = $query->getResult();
        
        
        return $this->render('DirasetBundle:inscrit:new.html.twig', array(
            'inscrit' => $inscrit,
            'cin' => $cin,
            'num' => $num,
            'D' => $D,
            'valeurAtributs' => $VA,
            'kesms' => $Kesm,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a inscrit entity.
     *
     */
    public function showAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $inscrit = $em->getRepository('DbBundle:Inscrit')->findOneBy(array('cin'=>$request->get('cin')));
        
        return $this->render('DirasetBundle:inscrit:show.html.twig', array(
            'inscrit' => $inscrit,
            ));
    }
    
    public function showPublicAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $deres = array();
        $itars = array();
        $chef = $em->getRepository('DbBundle:Chef')->findOneBy(array('cin'=>$request->get('cin')));
        if(count($chef) == 1){
            $deres = $em->getRepository('DbBundle:DeresDawra')->findBy(array('actif' => 1, 'idChef'=>$chef->getId() ));
        $itars = $em->getRepository('DbBundle:ItarDawra')->findBy(array('actif' => 1, 'idChef'=>$chef->getId() ));
        }
        
        
        
        return $this->render('DirasetBundle:inscrit:showPublic.html.twig', array(
            'chef' => $chef,
            'deres' => $deres,
            'itars' => $itars,
            ));
    }

    /**
     * Displays a form to edit an existing inscrit entity.
     *
     */
    public function editAction(Request $request, Inscrit $inscrit)
    {
        $msg = 0;
        if($request->get('msg')){
            $msg = $request->get('msg');
        }
        $imageA = $inscrit->getImageCinFace();
        $inscrit->setImageCinFace( new File($this->getParameter('cin_directory').'/'.$inscrit->getImageCinFace()));
        
        $imageA2 = $inscrit->getImageCinPile();
        $inscrit->setImageCinPile( new File($this->getParameter('cin_directory').'/'.$inscrit->getImageCinPile()));
        
        
        $deleteForm = $this->createDeleteForm($inscrit);
        $editForm = $this->createForm('DbBundle\Form\InscritType', $inscrit);
        $editForm->handleRequest($request);
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery('SELECT s FROM DbBundle:AtributType s WHERE s.id < 4 ');
        $VA = $query->getResult();
        $query = $em->createQuery('SELECT s FROM DbBundle:Kesm s WHERE s.id < 8 ');
        $Kesm = $query->getResult();
        if ($editForm->isSubmitted() && $editForm->isValid()) {
            
            if($inscrit->getImageCinFace()){
            $file = $inscrit->getImageCinFace();
            $fileName = md5(uniqid()).'.'.$file->guessExtension();
            $file->move(
                $this->getParameter('cin_directory'),
                $fileName
            );
            // end upload
            $inscrit->setImageCinFace($fileName);}
            else {
                $inscrit->setImageCinFace($imageA);
            }
            
            if($inscrit->getImageCinPile()){
            $file2 = $inscrit->getImageCinPile();
            $fileName2 = md5(uniqid()).'.'.$file2->guessExtension();
            $file2->move(
                $this->getParameter('cin_directory'),
                $fileName2
            );
            // end upload
            $inscrit->setImageCinPile($fileName2);}
            else {
                $inscrit->setImageCinPile($imageA2);
            }
            $lD = $em->getRepository('DbBundle:AtributType')->findOneBy(array('id'=>$request->get('lastDirassa')));
            $inscrit->setLastDirassa($lD);
            
            $Dr = $em->getRepository('DbBundle:AtributType')->findOneBy(array('id'=>$request->get('dirassa')));
            $inscrit->setIdDirassa($Dr);
            
            $Kesme = $em->getRepository('DbBundle:Kesm')->findOneBy(array('id'=>$request->get('kesm')));
            $inscrit->setIdKesm($Kesme);
            
            
            $em->merge($inscrit);
            $em->flush();

            return $this->redirectToRoute('inscrit_edit', array('id' => $inscrit->getId()));
        }

        return $this->render('DirasetBundle:inscrit:edit.html.twig', array(
            'inscrit' => $inscrit,
            'valeurAtributs' => $VA,
            'kesms' => $Kesm,
            'msg' => $msg,
            'i1' => $imageA,
            'i2' => $imageA2,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
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
