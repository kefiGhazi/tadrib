<?php

namespace SimpleChefBundle\Controller;

use DateTime;
use DbBundle\Entity\Chef;
use DbBundle\Entity\Inscrit;
use DbBundle\Entity\Link;
use DbBundle\Entity\SimpleChef;
use DbBundle\Entity\Raport;
use DbBundle\Entity\Tawsims;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * SimpleChef controller.
 *
 */
class SimpleChefController extends Controller {

    public $newCode = array(1, 8, 11);
    public $ibtida2yaCode = array(2, 9, 12);
    public $tamhidiyaCode = array(3, 10, 13);
    public $charaCode = array(4, 6, 14, 15, 16, 17, 18);
    public $mktCode = array(5, 7, 19, 14, 15, 16, 17, 18);
    public $ktCode = array(14, 15, 16, 17, 18, 19);

    public function indexAction(Request $request) {
        $SimpleChef = new SimpleChef();
        $form = $this->createForm('DbBundle\Form\SimpleChefType', $SimpleChef);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $chef = $em->getRepository('DbBundle:Chef')->findOneBy(array('inscrit' => $SimpleChef->getNumInscrit(), 'cin' => $SimpleChef->getCin(), 'actif' => 1));
            if ($chef) {
                $_SESSION["user"] = md5($chef->getCin());
                $_SESSION["userId"] = $chef->getId();
                return $this->redirectToRoute('simple_chef_show');
            } else {
                return $this->render('SimpleChefBundle:chef:index.html.twig', array(
                            'form' => $form->createView(),
                            'message' => array('text' => 'غير موجود بقاعدة البينات !', 'type' => 'warning', 'titre' => 'تحذير ')
                ));
            }
        }
        return $this->render('SimpleChefBundle:chef:index.html.twig', array(
                    'form' => $form->createView()
        ));
    }

    /**
     * Lists all diraset.
     *
     */
    public function listeDirasetAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $chefId = $_SESSION['userId'];
        $chef = $em->getRepository('DbBundle:Chef')->findOneById($chefId);
        if ($chef->getLastDirasa() == 'بدون تدريب') {
            $listeDiraset = $em->getRepository('DbBundle:Link')->findByIdJiha($chef->getIdJiha()->getId(), $this->newCode);
        } elseif ($chef->getLastDirasa() == 'ابتدائية') {
            $listeDiraset = $em->getRepository('DbBundle:Link')->findByIdJiha($chef->getIdJiha()->getId(), $this->ibtida2yaCode);
        } elseif ($chef->getLastDirasa() == 'تمهيدية') {
            $listeDiraset = $em->getRepository('DbBundle:Link')->findByIdJiha($chef->getIdJiha()->getId(), $this->tamhidiyaCode);
        } elseif ($chef->getLastDirasa() == 'شارة خشبية') {
            $listeDiraset = $em->getRepository('DbBundle:Link')->findByIdJiha($chef->getIdJiha()->getId(), $this->charaCode);
        } elseif ($chef->getLastDirasa() == 'مساعد قائد تدريب') {
            $listeDiraset = $em->getRepository('DbBundle:Link')->findByIdJiha($chef->getIdJiha()->getId(), $this->mktCode);
        } else {
            $listeDiraset = $em->getRepository('DbBundle:Link')->findByIdJiha($chef->getIdJiha()->getId(), $this->ktCode);
        }
        return $this->render('SimpleChefBundle:chef:listNewDiraset.html.twig', array(
                    'ListeDiraset' => $listeDiraset,
                    'chef' => $chef
        ));
    }

    
    public function showAction(Request $request) {
        try {
            $em = $this->getDoctrine()->getManager();
            $tadrib = array();
            if (isset($_SESSION['userId']) === false) {
                return $this->redirectToRoute('simple_chef_index');
            }
            $chefId = $_SESSION['userId'];
            $chef = $em->getRepository('DbBundle:Chef')->findOneById($chefId);
            $deres = $em->getRepository('DbBundle:DeresDawra')->findBy(array('actif' => 1, 'idChef' => $chefId));
            $itars = $em->getRepository('DbBundle:ItarDawra')->findBy(array('actif' => 1, 'idChef' => $chefId));


            //var_dump($tadrib[1]['dawra']);die();
            if ($request->get('message')) {
                return $this->render('SimpleChefBundle:chef:show.html.twig', array(
                            'message' => $request->get('message'),
                            'chef' => $chef,
                            'deres' => $deres,
                            'itars' => $itars,
                ));
            }
            return $this->render('SimpleChefBundle:chef:show.html.twig', array(
                        'chef' => $chef,
                        'deres' => $deres,
                        'itars' => $itars,
            ));
        } catch (Exception $ex) {
            $this->redirectToRoute('simple_chef_index');
        }
    }

    /**
     * Displays a form to edit an existing chef entity.
     *
     */
    public function editAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        if (isset($_SESSION['userId']) === false) {
            return $this->redirectToRoute('simple_chef_index');
        }
        $chefId = $_SESSION['userId'];
        $chef = $em->getRepository('DbBundle:Chef')->findOneById($chefId);

            $imageA = $chef->getImageCinFace();
            if($chef->getImageCinFace() != null ){
                $chef->setImageCinFace( new File($this->getParameter('cin_directory').'/'.$chef->getImageCinFace()));
            }

            $imageA2 = $chef->getImageCinPile();
            if($chef->getImageCinPile() != null ){
                $chef->setImageCinPile( new File($this->getParameter('cin_directory').'/'.$chef->getImageCinPile()));
            }

        $editForm = $this->createForm('DbBundle\Form\ChefEditeSimpleType', $chef);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            //$img = file_get_contents($editForm->get('imageCinFace')->getData());

            if($chef->getImageCinFace()){
                $file = $chef->getImageCinFace();
                $fileName = md5(uniqid()).'.'.$file->guessExtension();
                $file->move(
                    $this->getParameter('cin_directory'),
                    $fileName
                );
                // end upload
                $chef->setImageCinFace($fileName);}
            else {
                $chef->setImageCinFace($imageA);
            }

            if($chef->getImageCinPile()){
                $file2 = $chef->getImageCinPile();
                $fileName2 = md5(uniqid()).'.'.$file2->guessExtension();
                $file2->move(
                    $this->getParameter('cin_directory'),
                    $fileName2
                );
                // end upload
                $chef->setImageCinPile($fileName2);}
            else {
                $chef->setImageCinPile($imageA2);
            }

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('simple_chef_show');
        }

        return $this->render('SimpleChefBundle:chef:edit.html.twig', array(
                    'chef' => $chef,
                    'edit_form' => $editForm->createView(),
        ));
    }

    /**
     * @param Request $request
     * @param Link $link
     * @param Chef $chef
     */
    public function inscritAction(Request $request, Link $link , Chef $chef)
    {
        $em = $this->getDoctrine()->getManager();
        $inscrit = $em->getRepository('DbBundle:Inscrit')->findOneBy(array('idLink' => $link->getId(), 'idChef'=> $chef->getId()));
        if(!$inscrit){
            $inscrit = new Inscrit();
            $inscrit->setIdChef($chef);
            $inscrit->setIdLink($link);
        }
        $fileName = $inscrit->getIdChef()->getImageCinFace();
        $fileName2 = $inscrit->getIdChef()->getImageCinPile();
        if($fileName != null ){
            $inscrit->getIdChef()->setImageCinFace(
                new File($this->getParameter('cin_directory').'/'.$inscrit->getIdChef()->getImageCinFace())
            );
        }
        if($fileName2 != null ){
            $inscrit->getIdChef()->setImageCinPile(
                new File($this->getParameter('cin_directory').'/'.$inscrit->getIdChef()->getImageCinPile())
            );
        }
        $form = $this->createForm('DbBundle\Form\InscritType', $inscrit);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $inscrit->setIdDirassa($em->getRepository('DbBundle:AtributType')->findOneBy(array('id'=>$request->get('idDirasa'))));
            //  ulpoad image
            $file = $inscrit->getIdChef()->getImageCinFace();
            if($file && $file != null){
                $fileName = md5(uniqid()).'.'.$file->guessExtension();
                $file->move(
                    $this->getParameter('cin_directory'),
                    $fileName
                );
                // end upload
            }
            $inscrit->getIdChef()->setImageCinFace($fileName);

            //  ulpoad image
            $file2 = $inscrit->getIdChef()->getImageCinPile();
            if($file2 && $file2 != null ){
                $fileName2 = md5(uniqid()).'.'.$file2->guessExtension();
                $file2->move(
                    $this->getParameter('cin_directory'),
                    $fileName2
                );
                // end upload
            }
            $inscrit->getIdChef()->setImageCinPile($fileName2);
            $kesem = $em->getRepository('DbBundle:Kesm')->findOneBy(array('id' => $request->get('idKesm')));
            $inscrit->setIdKesm($kesem);
            $em->persist($inscrit);
            $em->persist($inscrit->getIdChef());
            $em->flush();
            $this->addFlash(
                'success',
                'تم التسجيل بنجاح'
            );
        }
        return $this->render( 'SimpleChefBundle:chef:inscrit.html.twig',array(
            'form' => $form->createView(),
            'diraset' => $link->getMostawaTadribis()->getValues(),
            'dirasa' => $link,
            'inscrit' => $inscrit,
        ));

    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function inscritListAction(Request $request )
    {
        $em = $this->getDoctrine()->getManager();
        if (isset($_SESSION['userId']) === false) {
            return $this->redirectToRoute('simple_chef_index');
        }
        $chefId = $_SESSION['userId'];
        $chef = $em->getRepository('DbBundle:Chef')->findOneById($chefId);
        $inscrit = $em->getRepository('DbBundle:Inscrit')->findBy(array('idChef' => $chef->getId()));
        return $this->render( 'SimpleChefBundle:chef:listInscrit.html.twig', array(
            'inscritList' => $inscrit,
            'chef' => $chef
        ));
    }


    public function printAction(Request $request, Inscrit $inscrit){
        return $this->render('SimpleChefBundle:chef:print.html.twig', array(
            'inscrit' => $inscrit
        ));
    }

    public function tawsimAction(Request $request){
        $em = $this->getDoctrine()->getManager();
        if (isset($_SESSION['userId']) === false) {
            return $this->redirectToRoute('simple_chef_index');
        }
        $chefId = $_SESSION['userId'];
        $chef = $em->getRepository('DbBundle:Chef')->findOneById($chefId);
        $tawsim = $em->getRepository('DbBundle:Tawsims')->findBy(array('idChef' => $chef->getId(), 'actif' => 1));
        $etat = $em->getRepository('DbBundle:Tawsims')->findBy(array('idChef' => $chef->getId(), 'actif' => 1, 'etat' => 0));

        return $this->render( 'SimpleChefBundle:chef:tawsim.html.twig', array(
            'demandes' => $tawsim,
            'chef' => $chef,
            'etat' => $etat
        ));

    }

    public function tawsimNewAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        if (isset($_SESSION['userId']) === false) {
            return $this->redirectToRoute('simple_chef_index');
        }
        $chefId = $_SESSION['userId'];
        $chef = $em->getRepository('DbBundle:Chef')->findOneById($chefId);

        $tawsim = new Tawsims();
        $tawsim->setIdChef($chef);
        $form = $this->createForm('DbBundle\Form\TawsimsType', $tawsim);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $tawsim->setActif(1)
                ->setDateDemande(new DateTime())
                ->setEtat(0);
            $em->persist($tawsim);
            $em->flush();
            $this->addFlash(
                'success',
                'لقد تمت الإضافة بنجاح'
            );
            return $this->redirectToRoute('simple_chef_tawsim_new');
        }
        return $this->render( 'SimpleChefBundle:chef:tawsimNew.html.twig',array(
            'form' => $form->createView(),
            'chef' => $chef
        ));
    }




}
