<?php

namespace SimpleChefBundle\Controller;

use DbBundle\Entity\Chef;
use DbBundle\Entity\SimpleChef;
use DbBundle\Entity\Raport;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
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
                    'ListeDiraset' => $listeDiraset
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
        $editForm = $this->createForm('DbBundle\Form\ChefEditeSimpleType', $chef);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('simple_chef_show');
        }

        return $this->render('SimpleChefBundle:chef:edit.html.twig', array(
                    'chef' => $chef,
                    'edit_form' => $editForm->createView(),
        ));
    }

}
