<?php

namespace TawsimBundle\Controller;

use DateTime;
use DbBundle\Entity\Tawsims;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $jiha = null;
        if($request->get('jiha')) { $jiha = $request->get('jiha');}

        $privilege = $em->getRepository('DbBundle:Privilaige')->findOneBy(array("actif" => 1, "idUser" => $this->get('security.context')->getToken()->getUser()->getId()));
        $allJiha = $em->getRepository('DbBundle:Jiha')->findAll();
        if ($privilege->getIdSifa()->getId() == 0 OR $privilege->getIdSifa()->getId() == 1 OR $privilege->getIdSifa()->getId() == 2) {
            if ($jiha) {
                $tawsimsDemande = $em->getRepository('DbBundle:Tawsims')->findBy(array('actif' => 1, 'idJiha' => $jiha));
            } else {
                $tawsimsDemande = $em->getRepository('DbBundle:Tawsims')->findBy(array('actif' => 1));
            }
        } else {
            $tawsimsDemande = $em->getRepository('DbBundle:Tawsims')->findBy(array('actif' => 1, 'idJiha' => $privilege->getIdJiha()->getId()));
        }
        return $this->render('TawsimBundle:Default:index.html.twig', array('demandeList' => $tawsimsDemande, 'J' => $jiha, 'jihas' => $allJiha));
    }

    public function acceptJihaAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        /** @var Tawsims $tawsims */
        $tawsims = $em->getRepository('DbBundle:Tawsims')->findOneBy(array('id' => $request->get('id')));

        $etat = $request->get('etat');
        if ('oui' === $etat) {
            $tawsims->setResponseJiha(1);
        } else {
            $tawsims->setResponseJiha(2);
            $tawsims->setMessageJiha($request->get('raison'));
        }
        $em->persist($tawsims);
        $em->flush();
        return $this->redirectToRoute('tawsim_homepage', array('jiha' => $request->get('jiha')));
    }

    public function acceptWataniAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        /** @var Tawsims $tawsims */
        $tawsims = $em->getRepository('DbBundle:Tawsims')->findOneBy(array('id' => $request->get('id')));

        $etat = $request->get('etat');
        if ('oui' === $etat) {
            $tawsims->setResponseWatani(1);
        } else {
            $tawsims->setResponseWatani(2);
            $tawsims->setMessageWatani($request->get('raison'));
        }
        $em->merge($tawsims);
        $em->flush();
        return $this->redirectToRoute('tawsim_homepage', array('jiha' => $request->get('jiha')));
    }

    public function addDemandeAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $tawsim = new Tawsims();
        $form = $this->createForm('DbBundle\Form\TawsimsType', $tawsim);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $chef = $em->getRepository('DbBundle:Chef')->findOneBy(['inscrit' => $request->get('inscrit')]);
            $tawsim->setIdChef($chef)
                    ->setActif(1)
                    ->setDateDemande(new DateTime())
                    ->setEtat(0);
            $em->persist($tawsim);
            $em->flush();
            $this->addFlash(
                'success',
                'لقد تمت الإضافة بنجاح'
            );
            return $this->redirectToRoute('tawsim_homepage');
        }
        return $this->render( 'TawsimBundle:Default:new.html.twig',array(
            'form' => $form->createView(),
            'tawsim' => $tawsim,
        ));
    }

    public function closeAction(Request $request, Tawsims $tawsims)
    {
        $em = $this->getDoctrine()->getManager();
        $tawsims->setEtat(1);
        $em->merge($tawsims);
        $em->flush();
        return $this->redirectToRoute('tawsim_homepage', array('jiha' => $request->get('jiha')));
    }

    public function deleteAction(Request $request, Tawsims $tawsims)
    {
        $em = $this->getDoctrine()->getManager();
        $tawsims->setActif(0);
        $em->merge($tawsims);
        $em->flush();
        return $this->redirectToRoute('tawsim_homepage', array('jiha' => $request->get('jiha')));
    }

    public function dateTawsimAction(Request $request, Tawsims $tawsims)
    {
        $em = $this->getDoctrine()->getManager();
        $tawsims->setDateTawsim(new \DateTime($request->get('tawsimDate')));
        $em->merge($tawsims);
        $em->flush();
        return $this->redirectToRoute('tawsim_homepage', array('jiha' => $request->get('jiha')));
    }
}
