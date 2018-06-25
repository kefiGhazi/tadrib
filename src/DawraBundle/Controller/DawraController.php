<?php

namespace DawraBundle\Controller;

use DbBundle\Entity\Dawra;
use DbBundle\Entity\Chef;
use DbBundle\Entity\ItarDawra;
use DbBundle\Entity\DeresDawra;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Dawra controller.
 *
 */
class DawraController extends Controller
{
    /**
     * Lists all dawra entities.
     *
     */
    public function indexAction(Request $request)
    {
        
        $ListChefs = array();
        $em = $this->getDoctrine()->getManager();
        $type = $em->getRepository('DbBundle:TypeDawra')->findOneBy(array('code' =>$request->get('type')));
        $privilege  = $em->getRepository('DbBundle:Privilaige')->findOneBy(array("actif"=>1,"idUser"=>$this->get('security.context')->getToken()->getUser()->getId()));
        
        if($privilege->getIdSifa()->getId() == 0 OR $privilege->getIdSifa()->getId() == 1 OR $privilege->getIdSifa()->getId() == 2){
        $dawras = $em->getRepository('DbBundle:Dawra')->findBy(array('actif'=>1,'idType'=>$type->getId()));
//        return $this->render('DawraBundle:dawra:index.html.twig', array(
//            'dawras' => $dawras,
//            'type' => $type,
//        ));
        }else{
           $dawras = $em->getRepository('DbBundle:Dawra')->findBy(array('actif'=>1,'idJiha'=>$privilege->getIdJiha()->getId(),'idType'=>$type->getId()));
        }
        
        foreach ($dawras as $dawra){
            $chef = $em->getRepository('DbBundle:ItarDawra')->findOneBy(array('actif'=>1,'idDawra'=>$dawra->getId(),'idSifa'=>4));
            if(count($chef) == 1){
                $ListChefs[$dawra->getId()] = $chef->getIdChef()->getNom().' '.$chef->getIdChef()->getPrenom();
            }else{
                $ListChefs[$dawra->getId()] = '--';
            }
            
        }
        
        if($request->get('message')){
            return $this->render('DawraBundle:dawra:index.html.twig', array(
                'dawras' => $dawras,
                'listChefs' => $ListChefs,
                'type' => $type,
                'message' => $request->get('message')
            ));
        }else{
            return $this->render('DawraBundle:dawra:index.html.twig', array(
                'dawras' => $dawras,
                'listChefs' => $ListChefs,
                'type' => $type,
            ));
        }
        
    }

    /**
     * Creates a new dawra entity.
     *
     */
    public function newAction(Request $request)
    {
        $dawra = new Dawra();
        $form = $this->createForm('DbBundle\Form\DawraType', $dawra);
        $form->handleRequest($request);
        $em = $this->getDoctrine()->getManager();
        $User = $this->get('security.context')->getToken()->getUser();
        $type = $em->getRepository('DbBundle:TypeDawra')->findOneBy(array('code' =>$request->get('type')));
        $atrib = $em->getRepository('DbBundle:AtributType')->findBy(array('idType'=>$type->getId()));
        $privilege  = $em->getRepository('DbBundle:Privilaige')->findOneBy(array("actif"=>1,"idUser"=>$User->getId()));
        $kesms = $em->getRepository('DbBundle:Kesm')->findAll();
        
        if($privilege->getIdSifa()->getId() == 0 OR $privilege->getIdSifa()->getId() == 1 OR $privilege->getIdSifa()->getId() == 2){
        $jihas = $em->getRepository('DbBundle:Jiha')->findAll();
        
        }else{
           $jihas = $em->getRepository('DbBundle:Jiha')->findBy(array('id'=>$privilege->getIdJiha()->getId()));
        }

        if ($form->isSubmitted() && $form->isValid()) {
            
            
            $dawra->setDateCreation(new \DateTime());
            $dawra->setActif(1);
            $currentUser = $em->getRepository('UserBundle:User')->findOneById($this->get('security.context')->getToken()->getUser());
            $dawra->setIdType($type);
            if($request->get('senef') != null){
                $atrib = $em->getRepository('DbBundle:AtributType')->findOneById($request->get('senef'));
                $dawra->setIdAtributType($atrib);
            }else{
                $dawra->setIdAtributType(null);
            }
            $jiha = $em->getRepository('DbBundle:Jiha')->findOneBy(array('id'=> $request->get('jiha')));
            $dawra->setIdJiha($jiha);
            $kesm = $em->getRepository('DbBundle:Kesm')->findOneBy(array('id'=> $request->get('kesm')));
            $dawra->setIdKesm($kesm);
            
            $dawra->setIdCreateur($currentUser);
            $em->persist($dawra);
            $em->flush();

            return $this->redirectToRoute('dawra_show', array('id' => $dawra->getId()));
        }

        return $this->render('DawraBundle:dawra:new.html.twig', array(
            'dawra' => $dawra,
            'jihas' => $jihas,
            'kesms' => $kesms,
            'atrib' => $atrib,
            'type' => $type,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a dawra entity.
     *
     */
    public function showAction(Dawra $dawra,Request $request)
    {
        $msg = null;
        $typeAlert = null;
        if($request->get('msg') != null){
            $msg = $request->get('msg');
        }
        if($request->get('typeAlert') != null){
            $typeAlert = $request->get('typeAlert');
        }
        $deleteForm = $this->createDeleteForm($dawra);
        $em = $this->getDoctrine()->getManager();
        
        $deresin = $em->getRepository('DbBundle:DeresDawra')->findBy(array('idDawra' => $dawra->getId()));
        $itar = $em->getRepository('DbBundle:ItarDawra')->findBy(array('idDawra' => $dawra->getId()));
        
       
        $kesms = $em->getRepository('DbBundle:Kesm')->findAll();
        
        $privilege  = $em->getRepository('DbBundle:Privilaige')->findOneBy(array("actif"=>1,"idUser"=>$this->get('security.context')->getToken()->getUser()->getId()));
        if($privilege->getIdSifa()->getId() == 0 OR $privilege->getIdSifa()->getId() == 1 OR $privilege->getIdSifa()->getId() == 2){
         $jihas = $em->getRepository('DbBundle:Jiha')->findAll();
        }else{
            $jihas = $em->getRepository('DbBundle:Jiha')->findBy(array('id'=>$privilege->getIdJiha()));
        }
        $query = $em->createQuery('SELECT s FROM DbBundle:Sifa s WHERE s.id > 3 AND s.id < 7');
        $sifa = $query->getResult();
        
        return $this->render('DawraBundle:dawra:show.html.twig', array(
            'dawra' => $dawra,
            'jihas' => $jihas,
            'kesms' => $kesms,
            'sifas' => $sifa,
            'deresins' => $deresin,
            'itars' => $itar,
            'msg' => $msg,
            'typeAlert' => $typeAlert,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    
    
    
    public function addMenbreAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $inscrit = $request->get('inscrit');
        $chef = $em->getRepository('DbBundle:Chef')->findOneBy(array('inscrit' =>$inscrit,'actif'=>1));
        $dawra =  $em->getRepository('DbBundle:Dawra')->findOneById($request->get('idDawra'));                     

        if($chef == NULL){
            return $this->redirectToRoute('dawra_show', array('id' => $dawra->getId(),'msg' => ' القائد غير موجود في قاعدة البيانات قم بإضافته أولا'));
        }
        
        $chefDawraDeres = $em->getRepository('DbBundle:DeresDawra')->findBy(array('idDawra'=>$dawra->getId(),'idChef'=>$chef->getId()));
        $chefDawraItar = $em->getRepository('DbBundle:ItarDawra')->findBy(array('idDawra'=>$dawra->getId(),'idChef'=>$chef->getId()));
        if($chefDawraDeres != NULL || $chefDawraItar != NULL ){
            return $this->redirectToRoute('dawra_show', array('id' => $dawra->getId(),'msg' => ' لقد قمت بإضافة القائد في الدورةالتدريبية','typeAlert'=>'warning'));
        }
        
        $type = $request->get('type');
        if($type == 'I'){
            $sifa =  $em->getRepository('DbBundle:Sifa')->findOneById($request->get('sifa'));   
            $itarDawra = new ItarDawra();
            $itarDawra->setActif(1);
            $itarDawra->setIdChef($chef);
            $itarDawra->setIdDawra($dawra);
            $itarDawra->setIdSifa($sifa);
            $em->persist($itarDawra);
            $em->flush();
        } else {
            $sifa =  $em->getRepository('DbBundle:Sifa')->findOneById(7);   
            $deresDawra = new DeresDawra();
            $deresDawra->setActif(1);
            $deresDawra->setIdChef($chef);
            $deresDawra->setIdDawra($dawra);
            $deresDawra->setIdSifa($sifa);
            $deresDawra->setResult($request->get('result'));
            $em->persist($deresDawra);
            $em->flush();
        }
        return $this->redirectToRoute('dawra_show', array('id' => $dawra->getId(),'msg' => ' لقد تمت الإضافة بنجاح','typeAlert'=>'success'));
    }

    /**
     * Displays a form to edit an existing dawra entity.
     *
     */
    public function editAction(Request $request, Dawra $dawra)
    {
        $deleteForm = $this->createDeleteForm($dawra);
        $editForm = $this->createForm('DbBundle\Form\DawraType', $dawra);
        $editForm->handleRequest($request);
        $em = $this->getDoctrine()->getManager();
        $User = $this->get('security.context')->getToken()->getUser();
        $type = $em->getRepository('DbBundle:TypeDawra')->findOneBy(array('code' =>$request->get('type')));
        
        $atrib = $em->getRepository('DbBundle:AtributType')->findBy(array('idType'=>$type->getId()));
        $kesms = $em->getRepository('DbBundle:Kesm')->findAll();
        
        $privilege  = $em->getRepository('DbBundle:Privilaige')->findOneBy(array("actif"=>1,"idUser"=>$User->getId()));
        if($privilege->getIdSifa()->getId() == 0 OR $privilege->getIdSifa()->getId() == 1 OR $privilege->getIdSifa()->getId() == 2){
        $jihas = $em->getRepository('DbBundle:Jiha')->findAll();
        
        }else{
           $jihas = $em->getRepository('DbBundle:Jiha')->findBy(array('id'=>$privilege->getIdJiha()->getId()));
        }
        
        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            if($request->get('senef') != null){
                $atrib = $em->getRepository('DbBundle:AtributType')->findOneById($request->get('senef'));
                $dawra->setIdAtributType($atrib);
            }else{
                $dawra->setIdAtributType(null);
            }
            $jiha2 = $em->getRepository('DbBundle:Jiha')->findOneBy(array('id'=> $request->get('jiha')));
            $dawra->setIdJiha($jiha2);
             $kesm = $em->getRepository('DbBundle:Kesm')->findOneBy(array('id'=> $request->get('kesm')));
            $dawra->setIdKesm($kesm);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('dawra_show', array('id' => $dawra->getId(),'msg' => '  تمت التعديل  بنجاح','typeAlert'=>'success'));
        }

        return $this->render('DawraBundle:dawra:edit.html.twig', array(
            'dawra' => $dawra,
            'jihas' => $jihas,
            'kesms' => $kesms,
            'atrib' => $atrib,
            'type' => $type,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a dawra entity.
     *
     */
    public function deleteAction(Request $request, Dawra $dawra)
    {
//        $form = $this->createDeleteForm($dawra);
//        $form->handleRequest($request);
//
//        if ($form->isSubmitted() && $form->isValid()) {
//            $em = $this->getDoctrine()->getManager();
//            $em->remove($dawra);
//            $em->flush();
//        }
            $em = $this->getDoctrine()->getManager();
            $dawra->setActif(0);
            $em->merge($dawra);
            $em->flush();
        return $this->redirectToRoute('dawra_index',array('message' => array('text' => 'تمت المسح بنجاح !','type' => 'success','titre' => 'شكرا ')));
    }

    /**
     * Creates a form to delete a dawra entity.
     *
     * @param Dawra $dawra The dawra entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Dawra $dawra)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('dawra_delete', array('id' => $dawra->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
