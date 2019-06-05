<?php

namespace DemandeDawraBundle\Controller;

use DbBundle\Entity\DemandeDawra;
use DbBundle\Entity\Dawra;
use DbBundle\Entity\Chef;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * DemandeDawra controller.
 *
 */
class DemandeDawraController extends Controller {

    /**
     * Lists all dawra entities.
     *
     */
    public function indexAction(Request $request) {

        $em = $this->getDoctrine()->getManager();
        $type = $em->getRepository('DbBundle:TypeDawra')->findOneBy(array('code' => $request->get('type')));
        $privilege = $em->getRepository('DbBundle:Privilaige')->findOneBy(array("actif" => 1, "idUser" => $this->get('security.context')->getToken()->getUser()->getId()));

        if ($privilege->getIdSifa()->getId() == 0 OR $privilege->getIdSifa()->getId() == 1 OR $privilege->getIdSifa()->getId() == 2) {
            $dawras = $em->getRepository('DbBundle:DemandeDawra')->findBy(array('actif' => 1));
        } else {
            $dawras = $em->getRepository('DbBundle:DemandeDawra')->findBy(array('actif' => 1, 'idJiha' => $privilege->getIdJiha()->getId()));
        }


        if ($request->get('message')) {
            return $this->render('DemandeDawraBundle:demandeDawra:index.html.twig', array(
                        'dawras' => $dawras,
                        'type' => $type,
                        'message' => $request->get('message')
            ));
        } else {
            return $this->render('DemandeDawraBundle:demandeDawra:index.html.twig', array(
                        'dawras' => $dawras,
                        'type' => $type,
            ));
        }
    }

    /**
     * Creates a new dawra entity.
     *
     */
    public function newAction(Request $request) {
        $dawra = new DemandeDawra();
        $form = $this->createForm('DbBundle\Form\DemandeDawraType', $dawra);
        $form->handleRequest($request);
        $em = $this->getDoctrine()->getManager();
        $User = $this->get('security.context')->getToken()->getUser();
        $atrib = $em->getRepository('DbBundle:AtributType')->findAll();
        $privilege = $em->getRepository('DbBundle:Privilaige')->findOneBy(array("actif" => 1, "idUser" => $User->getId()));
        $kesms = $em->getRepository('DbBundle:Kesm')->findAll();

        if ($privilege->getIdSifa()->getId() == 0 OR $privilege->getIdSifa()->getId() == 1 OR $privilege->getIdSifa()->getId() == 2) {
            $jihas = $em->getRepository('DbBundle:Jiha')->findAll();
        } else {
            $jihas = $em->getRepository('DbBundle:Jiha')->findBy(array('id' => $privilege->getIdJiha()->getId()));
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $dawra->setDateCreation(new \DateTime());
            $dawra->setActif(1);
            $currentUser = $em->getRepository('UserBundle:User')->findOneById($this->get('security.context')->getToken()->getUser());
            $atrib = $em->getRepository('DbBundle:AtributType')->findOneBy(array('id' => $request->get('senef')));
            $dawra->setIdType($atrib->getIdType());
            $dawra->setIdAtributType($atrib);
            $jiha = $em->getRepository('DbBundle:Jiha')->findOneBy(array('id' => $request->get('jiha')));
            $dawra->setIdJiha($jiha);
            $kesm = $em->getRepository('DbBundle:Kesm')->findOneBy(array('id' => $request->get('kesm')));
            $dawra->setIdKesm($kesm);
            $dawra->setIdCreateur($currentUser);
            $em->persist($dawra);
            $em->flush();

            return $this->redirectToRoute('demande_dawra_index', array('msg' => ' لقد تمت الإضافة بنجاح', 'typeAlert' => 'success'));
        }

        return $this->render('DemandeDawraBundle:demandeDawra:new.html.twig', array(
                    'dawra' => $dawra,
                    'jihas' => $jihas,
                    'kesms' => $kesms,
                    'atrib' => $atrib,
                    'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a dawra entity.
     *
     */
    public function showAction(Dawra $dawra, Request $request) {
        $msg = null;
        $typeAlert = null;
        if ($request->get('msg') != null) {
            $msg = $request->get('msg');
        }
        if ($request->get('typeAlert') != null) {
            $typeAlert = $request->get('typeAlert');
        }
        $deleteForm = $this->createDeleteForm($dawra);
        $em = $this->getDoctrine()->getManager();

        $deresin = $em->getRepository('DbBundle:DeresDawra')->findBy(array('idDawra' => $dawra->getId()));
        $itar = $em->getRepository('DbBundle:ItarDawra')->findBy(array('idDawra' => $dawra->getId()));


        $kesms = $em->getRepository('DbBundle:Kesm')->findAll();

        $privilege = $em->getRepository('DbBundle:Privilaige')->findOneBy(array("actif" => 1, "idUser" => $this->get('security.context')->getToken()->getUser()->getId()));
        if ($privilege->getIdSifa()->getId() == 0 OR $privilege->getIdSifa()->getId() == 1 OR $privilege->getIdSifa()->getId() == 2) {
            $jihas = $em->getRepository('DbBundle:Jiha')->findAll();
        } else {
            $jihas = $em->getRepository('DbBundle:Jiha')->findBy(array('id' => $privilege->getIdJiha()));
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

    /**
     * Displays a form to edit an existing dawra entity.
     *
     */
    public function editAction(Request $request, DemandeDawra $dawra) {
        $editForm = $this->createForm('DbBundle\Form\DemandeDawraType', $dawra);
        $editForm->handleRequest($request);
        $em = $this->getDoctrine()->getManager();
        $User = $this->get('security.context')->getToken()->getUser();

        $atrib = $em->getRepository('DbBundle:AtributType')->findAll();
        $kesms = $em->getRepository('DbBundle:Kesm')->findAll();

        $privilege = $em->getRepository('DbBundle:Privilaige')->findOneBy(array("actif" => 1, "idUser" => $User->getId()));
        if ($privilege->getIdSifa()->getId() == 0 OR $privilege->getIdSifa()->getId() == 1 OR $privilege->getIdSifa()->getId() == 2) {
            $jihas = $em->getRepository('DbBundle:Jiha')->findAll();
        } else {
            $jihas = $em->getRepository('DbBundle:Jiha')->findBy(array('id' => $privilege->getIdJiha()->getId()));
        }

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $atrib = $em->getRepository('DbBundle:AtributType')->findOneBy(array('id' => $request->get('senef')));
            $dawra->setIdType($atrib->getIdType());
            $dawra->setIdAtributType($atrib);

            $jiha2 = $em->getRepository('DbBundle:Jiha')->findOneBy(array('id' => $request->get('jiha')));
            $dawra->setIdJiha($jiha2);
            $kesm = $em->getRepository('DbBundle:Kesm')->findOneBy(array('id' => $request->get('kesm')));
            $dawra->setIdKesm($kesm);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('demande_dawra_index', array('message' => array('text' => '  تمت التعديل  بنجاح', 'type' => 'success', 'titre' => 'شكرا ')));
        }

        return $this->render('DemandeDawraBundle:demandeDawra:edit.html.twig', array(
                    'dawra' => $dawra,
                    'jihas' => $jihas,
                    'kesms' => $kesms,
                    'atrib' => $atrib,
                    'form' => $editForm->createView(),
        ));
    }

    /**
     * Deletes a dawra entity.
     *
     */
    public function deleteAction(Request $request, DemandeDawra $dawra) {

        $em = $this->getDoctrine()->getManager();
        $dawra->setActif(0);
        $em->merge($dawra);
        $em->flush();
        return $this->redirectToRoute('demande_dawra_index', array('message' => array('text' => 'تمت المسح بنجاح !', 'type' => 'success', 'titre' => 'شكرا ')));
    }

    public function acceptAction(Request $request, DemandeDawra $demandeDawra) {
        try {
            $em = $this->getDoctrine()->getManager();
            $repense = $request->get('repense');
            if ($repense == 2) {
                $demandeDawra->setRaison($request->get('raison'));
            }
            $demandeDawra->setDateAccept(new \DateTime());
            $demandeDawra->setRepense($repense);
            $em->merge($demandeDawra);
            $em->flush();
            return $this->redirectToRoute('demande_dawra_index');
        } catch (\Exception $ex) {
            return $this->redirectToRoute('demande_dawra_index');
        }
    }
    public function pdfAction(Request $request, DemandeDawra $demandeDawra) {
        
               return $this->render('DemandeDawraBundle:demandeDawra:pdf.html.twig', array(
                    'dawra' => $demandeDawra,
        ));
    }

    public function realiserAction(Request $request, DemandeDawra $demandeDawra) {
        try {

            $em = $this->getDoctrine()->getManager();
            $realiser = $request->get('repense');
            $demandeDawra->setRealiser($realiser);
            $em->merge($demandeDawra);
            $em->flush($demandeDawra);
            return $this->redirectToRoute('demande_dawra_index');
        } catch (\Exception $ex) {
            return $this->redirectToRoute('demande_dawra_index');
        }
    }
    
    public function genererAction(Request $request, DemandeDawra $demandeDawra) {
        try {

            $em = $this->getDoctrine()->getManager();
            $dawra = new Dawra();
            $dawra->setActif(1);
            $dawra->setDateCreation(new \DateTime());
            $dawra->setDateDeb($demandeDawra->getDateDeb());
            $dawra->setDateFin($demandeDawra->getDateFin());
            $dawra->setEtat('open');
            $dawra->setIdAtributType($demandeDawra->getIdAtributType());
            $dawra->setIdJiha($demandeDawra->getIdJiha());
            $dawra->setIdKesm($demandeDawra->getIdKesm());
            $dawra->setIdType($demandeDawra->getIdType());
            $dawra->setLieux($demandeDawra->getLieux());
            $dawra->setIdCreateur($this->get('security.context')->getToken()->getUser());
            $demandeDawra->setGenerer(1);
            $em->persist($dawra);
            $em->merge($demandeDawra);
            $em->flush();
            return $this->redirectToRoute('demande_dawra_index');
        } catch (\Exception $ex) {
            return $this->redirectToRoute('demande_dawra_index');
        }
    }

    /**
     * Creates a form to delete a dawra entity.
     *
     * @param Dawra $dawra The dawra entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Dawra $dawra) {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('dawra_delete', array('id' => $dawra->getId())))
                        ->setMethod('DELETE')
                        ->getForm()
        ;
    }

}
