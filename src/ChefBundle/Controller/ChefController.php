<?php

namespace ChefBundle\Controller;

use DbBundle\Entity\Chef;
use DbBundle\Entity\Raport;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Chef controller.
 *
 */
class ChefController extends Controller {

    /**
     * Lists all chef entities.
     *
     */
    public function indexAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $idUser = $this->getUser()->getId();
        $privilaige = $em->getRepository('DbBundle:Privilaige')->findOneById($idUser);
        $chefs = NULL;
        if ($privilaige->getIdJiha() == NULL) {
            $chefs = $em->getRepository('DbBundle:Chef')->findBy(array('actif' => 1));
        } else {
            $chefs = $em->getRepository('DbBundle:Chef')->findBy(array('idJiha' => $privilaige->getIdJiha(), 'actif' => 1));
        }

        if ($request->get('message')) {
            return $this->render('ChefBundle:chef:index.html.twig', array(
                        'chefs' => $chefs,
                        'message' => $request->get('message')
            ));
        } else {
            return $this->render('ChefBundle:chef:index.html.twig', array(
                        'chefs' => $chefs,
            ));
        }
    }
    public function indexTadribAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $idUser = $this->getUser()->getId();
        $privilaige = $em->getRepository('DbBundle:Privilaige')->findOneById($idUser);
        $chefs = NULL;  
        $CT = 'قائد تدريب';
        if ($privilaige->getIdJiha() == NULL) {
           $query = $em->createQuery("SELECT c FROM DbBundle:Chef c WHERE c.lastDirasa LIKE '%قائد تدريب%' AND c.actif = 1");
        } else {
            $query = $em->createQuery("SELECT c FROM DbBundle:Chef c WHERE c.lastDirasa LIKE '%قائد تدريب%' AND c.actif = 1 AND c.idJiha = ".$privilaige->getIdJiha()->getId());
        }
        $chefs = $query->getResult(); 
        if ($request->get('message')) {
            return $this->render('ChefBundle:chef:indexTadrib.html.twig', array(
                        'chefs' => $chefs,
                        'message' => $request->get('message')
            ));
        } else {
            return $this->render('ChefBundle:chef:indexTadrib.html.twig', array(
                        'chefs' => $chefs,
            ));
        }
    }

    public function exporterAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $idUser = $this->getUser()->getId();
        $privilaige = $em->getRepository('DbBundle:Privilaige')->findOneById($idUser);
        $chefs = NULL;
        if ($privilaige->getIdJiha() == NULL) {
            $chefs = $em->getRepository('DbBundle:Chef')->findBy(array('actif' => 1));
        } else {
            $chefs = $em->getRepository('DbBundle:Chef')->findBy(array('idJiha' => $privilaige->getIdJiha(), 'actif' => 1));
        }

        $this->download_send_headers("data_export_" . date("Y-m-d") . ".csv");
        echo $this->array2csv($chefs);

        $fp = fopen('file.csv', 'w');

        fclose($fp);
        echo($fp);

        return $fp;
    }

    private function array2csv($chefs) {

        ob_start();
        $fp = fopen("php://output", 'w');
        $someData = array(
            array('one', 'two', 'three'),
            array('واحد', 'اثنان', 'ثلاثة'),
            array('اربعة', 'خمسة', 'ستة'),
            array('سبعة', 'ثمانية', 'تسعة'),
        );
        foreach ($someData as $Data) {
            $fp .= implode(',', $Data) . "\r\n";
            //$chef = $this->getArrayFromObject($chef);
            //fputcsv($fp, $chef);
        }
        mb_convert_encoding($fp, 'UTF-16LE', 'UTF-8');

        fclose($fp);

        return ob_get_clean();
    }

    private function download_send_headers($filename) {
        // disable caching
        $now = gmdate("D, d M Y H:i:s");
        header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
        header("Cache-Control: max-age=0, no-cache, must-revalidate, proxy-revalidate");
        header("Last-Modified: {$now} GMT");

        // force download  
        header("Content-Type: application/force-download");
        header("Content-Type: application/octet-stream");
        header("Content-Type: application/download");

        // disposition / encoding on response body
        header("Content-Disposition: attachment;filename={$filename}");
        header("Content-Transfer-Encoding: binary");
    }

    private function getArrayFromObject(Chef $chef) {
        $newChef = array();
        $newChef['name'] = $chef->getNom();
        $newChef['prenom'] = $chef->getPrenom();
        return $newChef;
    }

    /**
     * Creates a new chef entity.
     *
     */
    public function newAction(Request $request) {
        $chef = new Chef();
        $em = $this->getDoctrine()->getManager();
        $idUser = $this->getUser()->getId();
        $privilaige = $em->getRepository('DbBundle:Privilaige')->findOneById($idUser);
        if ($privilaige->getIdJiha() == NULL) {
        $form = $this->createForm('DbBundle\Form\ChefType', $chef);
        }else{
        $form = $this->createForm('DbBundle\Form\ChefJihaType', $chef);
        }
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $chefA = $em->getRepository('DbBundle:Chef')->findOneBy(array('inscrit' => $chef->getInscrit(), 'actif' => 1));
            $chefC = $em->getRepository('DbBundle:Chef')->findOneBy(array('cin' => $chef->getCin(), 'actif' => 1));
            if ($chefA == NULL && $chefC == NULL) {
                $em->persist($chef);
                $em->flush();
                return $this->redirectToRoute('chef_show', array('id' => $chef->getId(), 'message' => array('text' => 'تمت الاضافة بنجاح !', 'type' => 'success', 'titre' => 'شكرا ')));
            } else {

                return $this->redirectToRoute('chef_new', array('message' => array('text' => 'القائد موجودب بقاعدة الينات !', 'type' => 'warning', 'titre' => 'تحذير ')));
            }
        }

        if ($request->get('message')) {
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

    public function showAction(Request $request, Chef $chef) {
        $deleteForm = $this->createDeleteForm($chef);
        $em = $this->getDoctrine()->getManager();
        $tadrib = array();
        $deres = $em->getRepository('DbBundle:DeresDawra')->findBy(array('actif' => 1, 'idChef' => $chef->getId()));
        $itars = $em->getRepository('DbBundle:ItarDawra')->findBy(array('actif' => 1, 'idChef' => $chef->getId()));


        //var_dump($tadrib[1]['dawra']);die();
        if ($request->get('message')) {
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

    public function listErchedAction(Request $request) {

        try {
            $em = $this->getDoctrine()->getManager();
            $raports = $em->getRepository('DbBundle:Raport')->findBy(array('actif' => 1));
            return $this->render('ChefBundle:chef:indexErched.html.twig', array(
                        'raports' => $raports,
            ));
        } catch (Exception $ex) {
            
        }
    }

    /**
     * Finds and displays a chef entity.
     *
     */
    public function showErchedAction(Request $request, Chef $chef) {

        $em = $this->getDoctrine()->getManager();
        $raports = array();
        $raports = $em->getRepository('DbBundle:Raport')->findBy(array('actif' => 1, 'idChef' => $chef->getId()));


        if ($request->get('message')) {
            return $this->render('ChefBundle:chef:showErched.html.twig', array(
                        'message' => $request->get('message'),
                        'chef' => $chef,
                        'raports' => $raports,
            ));
        }
        return $this->render('ChefBundle:chef:showErched.html.twig', array(
                    'chef' => $chef,
                    'raports' => $raports,
        ));
    }

    /**
     * Finds and displays a chef entity.
     *
     */
    public function getChefErchedAction(Request $request, Raport $raport) {
        $jsonRaport = array();
        $jsonRaport['id'] = $raport->getId();
        $jsonRaport['activite'] = $raport->getActivite();
        $jsonRaport['cause'] = $raport->getCause();
        $jsonRaport['date'] = $raport->getDate()->format('Y-m-d');
        $jsonRaport['lieu'] = $raport->getLieu();
        $jsonRaport['mochref'] = $raport->getMochref();
        $jsonRaport['note'] = $raport->getNote();
        $jsonRaport['resume'] = $raport->getResume();

        return new JsonResponse(array('result' => "success", 'data' => $jsonRaport));
    }

    public function addErchedAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $chef = $em->getRepository('DbBundle:Chef')->findOneById($request->get('idChef'));
        try {
            $raport = new Raport();
            $raport->setActivite($request->get('activite'));
            $raport->setCause($request->get('cause'));
            $raport->setIdChef($chef);
            $raport->setLieu($request->get('lieu'));
            $raport->setMochref($request->get('mochref'));
            $raport->setNote($request->get('note'));
            $date = new \DateTime($request->get('date'));
            $raport->setDate($date);
            $raport->setResume($request->get('resume'));
            $raport->setActif(1);
            $em->persist($raport);
            $em->flush();
            return $this->redirectToRoute('chef_erched_show', array('id' => $chef->getId(), 'message' => array('text' => 'تمت الاضافة بنجاح !', 'type' => 'success', 'titre' => 'شكرا ')));
        } catch (\Exception $ex) {
            var_dump($ex->getMessage());
            die();
            return $this->redirectToRoute('chef_erched_show', array('id' => $chef->getId(), 'message' => array('text' => 'إضافى التقرير لم تتم ', 'type' => 'error', 'titre' => 'عذرا ')));
        }
    }

    public function editErchedAction(Request $request) {
        $idRaport = $request->get('idRaport');
        try {
            $em = $this->getDoctrine()->getManager();
            $raport = $em->getRepository('DbBundle:Raport')->findOneById($idRaport);

            $raport->setActivite($request->get('activite'));
            $raport->setCause($request->get('cause'));
            $raport->setLieu($request->get('lieu'));
            $raport->setMochref($request->get('mochref'));
            $raport->setNote($request->get('note'));
            $date = new \DateTime($request->get('date'));
            $raport->setDate($date);
            $raport->setResume($request->get('resume'));
            $em->merge($raport);
            $em->flush();
            return $this->redirectToRoute('chef_erched_show', array('id' => $raport->getIdChef()->getId(), 'message' => array('text' => 'تمت التعديل بنجاح !', 'type' => 'success', 'titre' => 'شكرا ')));
        } catch (\Exception $ex) {
            var_dump($ex->getMessage());
            die();
            return $this->redirectToRoute('chef_erched_show', array('id' => $chef->getId(), 'message' => array('text' => 'تعديل التقرير لم تتم ', 'type' => 'error', 'titre' => 'عذرا ')));
        }
    }

    public function deleteErchedAction(Request $request, Raport $raport) {
        $em = $this->getDoctrine()->getManager();
        try {
            $raport->setActif(0);
            $em->merge($raport);
            $em->flush();
            return $this->redirectToRoute('chef_erched_show', array('id' => $raport->getIdChef()->getId(), 'message' => array('text' => 'تمت المسح بنجاح !', 'type' => 'success', 'titre' => 'شكرا ')));
        } catch (\Exception $ex) {
            var_dump($ex->getMessage());
            die();
            return $this->redirectToRoute('chef_erched_show', array('id' => $raport->getIdChef()->getId(), 'message' => array('text' => 'تمت المسح بنجاح لم', 'type' => 'error', 'titre' => 'عذرا ')));
        }
    }

    /**
     * verifier si chef a des formation .
     *
     */
    public function verifAction(Request $request) {
        try {

            $numInscrit = $request->get('numInscrit');
            $chef = $this->getDoctrine()->getManager()->getRepository('DbBundle:Chef')->findOneBy(array('actif' => 1, 'inscrit' => $numInscrit));
            if ($chef != NULL) {
                $DES = array();
                $Ch = array('nom' => $chef->getNom() . ' ' . $chef->getPrenom(), 'cin' => $chef->getCin(), 'numInscrit' => $chef->getInscrit());
                $deres = $this->getDoctrine()->getManager()->getRepository('DbBundle:DeresDawra')->findBy(array('actif' => 1, 'idChef' => $chef->getId()));
                if (count($deres) != NULL) {
                    foreach ($deres as $dawra) {
                        $DE = array(
                            'dawraN' => $dawra->getIdDawra()->getIdAtributType()->getNom(),
                            'dawraT' => $dawra->getIdDawra()->getIdType()->getNom(),
                            'dateD' => $dawra->getIdDawra()->getDateDeb()->format('d-m-Y'),
                            'dateF' => $dawra->getIdDawra()->getDateFin()->format('d-m-Y'),
                            'lieu' => $dawra->getIdDawra()->getLieux(),
                            'id' => $dawra->getIdDawra()->getId()
                        );
                        array_push($DES, $DE);
                    }
                }
                return new JsonResponse(array('result' => "success", "deres" => $DES, "chef" => $Ch));
            } else {
                return new JsonResponse(array('result' => "error"));
            }
        } catch (Exception $ex) {
            
        }
    }

    /**
     * Displays a form to edit an existing chef entity.
     *
     */
    public function editAction(Request $request, Chef $chef) {
        $deleteForm = $this->createDeleteForm($chef);
        $idUser = $this->getUser()->getId();
        $privilaige = $this->getDoctrine()->getManager()->getRepository('DbBundle:Privilaige')->findOneById($idUser);
        if ($privilaige->getIdJiha() == NULL) {
        $editForm = $this->createForm('DbBundle\Form\ChefType', $chef);
        }else{
        $editForm = $this->createForm('DbBundle\Form\ChefJihaType', $chef);
        }
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

    public function updateAction(Request $request) {

        $em = $this->getDoctrine()->getManager();
        $chefs = $em->getRepository('DbBundle:Chef')->findBy(array('actif' => 1));

        foreach ($chefs as $chef) {
            if (strlen($chef->getCin()) < 8) {
                $text = $chef->getCin();
                $J = 8 - strlen($chef->getCin());
                for ($i = 1; $i <= $J; $i++) {
                    $text = '0' . $text;
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
    public function deleteAction(Request $request, Chef $chef) {
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
        $inscri = $chef->getInscrit() . "SUPR";
        $cin = $chef->getCin() . "SUPR";
        $chef->setInscrit($inscri);
        $chef->setCin($cin);
        $em->merge($chef);
        $em->flush();
        return $this->redirectToRoute('chef_index', array('message' => array('text' => 'تمت المسح بنجاح !', 'type' => 'success', 'titre' => 'شكرا ')));
    }

    /**
     * Creates a form to delete a chef entity.
     *
     * @param Chef $chef The chef entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Chef $chef) {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('chef_delete', array('id' => $chef->getId())))
                        ->setMethod('DELETE')
                        ->getForm()
        ;
    }

}
