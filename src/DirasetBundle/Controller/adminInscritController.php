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
class adminInscritController extends Controller {

    /**
     * Lists all inscrit entities.
     *
     */
    public function indexAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $link = $em->getRepository('DbBundle:Link')->findOneBy(array('id'=> $request->get('id')));
        $idUser = $this->getUser()->getId();
        $privilaige = $em->getRepository('DbBundle:Privilaige')->findOneById($idUser);
        $chefs = NULL;
        if ($privilaige->getIdJiha() == NULL) {
            $inscrits = $em->getRepository('DbBundle:Inscrit')->findBy(array('idLink' => $link->getId()));
        } else {
            $inscrits = $em->getRepository('DbBundle:Inscrit')->findByJiha(array('idLink' => $link->getId(), 'idJiha' => $privilaige->getIdJiha()->getId()));
        }

        return $this->render('DirasetBundle:adminInscrit:index.html.twig', array(
                    'inscrits' => $inscrits,
                    'link' => $link,
        ));
    }

    public function finalResultAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $link = $em->getRepository('DbBundle:Link')->findOneBy(array('id'=>$request->get('id')));
        $condition = "";
        $J = "";
        $D = "";

        $idUser = $this->getUser()->getId();
        $privilaige = $em->getRepository('DbBundle:Privilaige')->findOneById($idUser);
        if ($privilaige->getIdJiha() == NULL) {
            if ($request->get('jiha') != NULL) {
                $J = $request->get('jiha');
                $condition = $condition . "  AND p.idJiha ='" . $request->get('jiha') . "'";
            }
        } else {
            $J = $privilaige->getIdJiha();
            $condition = $condition . "  AND p.idJiha ='" . $privilaige->getIdJiha()->getId() . "'";
        }
        if ($request->get('Dirassa') != NULL) {
            $D = $request->get('Dirassa');
            $condition = $condition . "  AND p.idDirassa ='" . $request->get('Dirassa') . "'";
        }

        
        $query = $em->createQuery("select p from DbBundle\Entity\Inscrit p where  p.accepteW = 1 AND p.paye = 1" . $condition);
        $inscrit = $query->getResult();
        
        $query = $em->createQuery("select p from DbBundle\Entity\Kesm p where p.id <8 ");
        $kesms = $query->getResult();
        
         if ($privilaige->getIdJiha() == NULL) {
            $queryJ = $em->createQuery("select p from DbBundle\Entity\Jiha p ");
        } else {
            $queryJ = $em->createQuery("select p from DbBundle\Entity\Jiha p where p.id =".$privilaige->getIdJiha()->getId());
            
        }
        
        $jihas = $queryJ->getResult();
        

       
        return $this->render('DirasetBundle:adminInscrit:finalResult.html.twig', array(
                    'inscrits' => $inscrit,
                    'J' => $J,
                    'D' => $D,
                    'kesms' => $kesms,
                    'link' => $link,
                    'jihas' => $jihas,
            ));
    }

    public function aceptResultAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $link = $em->getRepository('DbBundle:Link')->findOneBy(array('id'=> $request->get('id')));

        $J = null ;
        $D = null;

        if ($request->get('jiha') != NULL){
            $J = $request->get('jiha');
        }
        if ($request->get('Dirassa') != NULL){
            $D = $request->get('Dirassa');
        }

            $inscrit = $em->getRepository('DbBundle:Inscrit')->findByAcceptWatani(array('jiha' => $J , 'dirassa' => $D , 'idLink' => $link->getId()));
        $jihas = $em->getRepository('DbBundle:Jiha')->findAll();
        return $this->render('DirasetBundle:adminInscrit:accepterResultW.html.twig', array(
                    'inscrits' => $inscrit,
                    'J' => $J,
                    'D' => $D,
                    'link' => $link,
                    'jihas' => $jihas));
    }

    /**
     * Creates a new inscrit entity.
     *
     */
    public function newAction(Request $request) {

        $em = $this->getDoctrine()->getManager();
        $cin = $request->get('cin');
        $num = $request->get('num');
        $D = $request->get('D');
        if ($request->get('cin') && $request->get('num')) {

            $query = $em->createQuery('SELECT s FROM DbBundle:Inscrit s WHERE s.cin = ' . $cin . ' AND s.numeroInscrit = ' . $num);
            $VA = $query->getResult();
            if (count($VA)) {
                return $this->redirectToRoute('inscrit_edit', array('id' => $VA[0]->getId(), 'msg' => 1));
            }
        }
        $inscrit = new Inscrit();


        $query = $em->createQuery('SELECT s FROM DbBundle:AtributType s WHERE s.id < 4 ');
        $VA = $query->getResult();
        $query = $em->createQuery('SELECT s FROM DbBundle:Kesm s WHERE s.id < 8 ');
        $Kesm = $query->getResult();

        $form = $this->createForm('DbBundle\Form\InscritType', $inscrit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            //  ulpoad image
            $file = $inscrit->getImageCinFace();
            $fileName = md5(uniqid()) . '.' . $file->guessExtension();
            $file->move(
                    $this->getParameter('cin_directory'), $fileName
            );
            // end upload
            $inscrit->setImageCinFace($fileName);

            //  ulpoad image
            $file2 = $inscrit->getImageCinPile();
            $fileName2 = md5(uniqid()) . '.' . $file2->guessExtension();
            $file2->move(
                    $this->getParameter('cin_directory'), $fileName2
            );
            // end upload
            $inscrit->setImageCinPile($fileName2);


            $lD = $em->getRepository('DbBundle:AtributType')->findOneBy(array('id' => $request->get('lastDirassa')));
            $inscrit->setLastDirassa($lD);

            $Dr = $em->getRepository('DbBundle:AtributType')->findOneBy(array('id' => $request->get('dirassa')));
            $inscrit->setIdDirassa($Dr);

            $Kesme = $em->getRepository('DbBundle:Kesm')->findOneBy(array('id' => $request->get('kesm')));
            $inscrit->setIdKesm($Kesme);

            $em->persist($inscrit);
            $em->flush();

            return $this->redirectToRoute('inscrit_edit', array('id' => $inscrit->getId(), 'msg' => 2));
        }


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
    public function showAction(Inscrit $inscrit) {
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
    public function editAction(Request $request, Inscrit $inscrit) {
        $msg = 0;
        if ($request->get('msg')) {
            $msg = $request->get('msg');
        }
        $imageA = $inscrit->getImageCinFace();
        $inscrit->setImageCinFace(new File($this->getParameter('cin_directory') . '/' . $inscrit->getImageCinFace()));

        $imageA2 = $inscrit->getImageCinPile();
        $inscrit->setImageCinPile(new File($this->getParameter('cin_directory') . '/' . $inscrit->getImageCinPile()));


        $deleteForm = $this->createDeleteForm($inscrit);
        $editForm = $this->createForm('DbBundle\Form\InscritType', $inscrit);
        $editForm->handleRequest($request);
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery('SELECT s FROM DbBundle:AtributType s WHERE s.id < 4 ');
        $VA = $query->getResult();
        $query = $em->createQuery('SELECT s FROM DbBundle:Kesm s WHERE s.id < 8 ');
        $Kesm = $query->getResult();
        if ($editForm->isSubmitted() && $editForm->isValid()) {

            if ($inscrit->getImageCinFace()) {
                $file = $inscrit->getImageCinFace();
                $fileName = md5(uniqid()) . '.' . $file->guessExtension();
                $file->move(
                        $this->getParameter('cin_directory'), $fileName
                );
                // end upload
                $inscrit->setImageCinFace($fileName);
            } else {
                $inscrit->setImageCinFace($imageA);
            }

            if ($inscrit->getImageCinPile()) {
                $file2 = $inscrit->getImageCinFace();
                $fileName2 = md5(uniqid()) . '.' . $file2->guessExtension();
                $file2->move(
                        $this->getParameter('cin_directory'), $fileName2
                );
                // end upload
                $inscrit->setImageCinPile($fileName);
            } else {
                $inscrit->setImageCinPile($imageA2);
            }
            $lD = $em->getRepository('DbBundle:AtributType')->findOneBy(array('id' => $request->get('lastDirassa')));
            $inscrit->setLastDirassa($lD);

            $Dr = $em->getRepository('DbBundle:AtributType')->findOneBy(array('id' => $request->get('dirassa')));
            $inscrit->setIdDirassa($Dr);

            $Kesme = $em->getRepository('DbBundle:Kesm')->findOneBy(array('id' => $request->get('kesm')));
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
    public function deleteAction(Request $request, Inscrit $inscrit) {
        $form = $this->createDeleteForm($inscrit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($inscrit);
            $em->flush();
        }

        return $this->redirectToRoute('inscrit_index');
    }

    public function accepterWAction(Request $request) {

        $em = $this->getDoctrine()->getManager();
        $J = null;
        $D = null;
        $link = $em->getRepository('DbBundle:Link')->findOneBy(array('id'=> $request->get('idLink')));
        if ($request->get('id')) {
            $Ins = $em->getRepository('DbBundle:Inscrit')->findOneBy(array('id' => $request->get('id')));
            if ($request->get('etat') == 'oui') {
                $Ins->setAccepteW(1);
            } else {
                $Ins->setAccepteW(2);
                $Ins->setAccepteMessageW($request->get('raison'));
            }
            $em->merge($Ins);
            $em->flush();
        }

        if ($request->get('jiha') != NULL ) {
            $J = $request->get('jiha');
        }
        if ($request->get('Dirassa') != NULL ) {
            $D = $request->get('Dirassa');
        }
        $inscrit = $em->getRepository('DbBundle:Inscrit')->findByWatani(array('idLink' => $link->getId() , 'jiha' => $J, 'dirassa'=>$D));
        $jihas = $em->getRepository('DbBundle:Jiha')->findAll();
        return $this->render('DirasetBundle:adminInscrit:accepterW.html.twig', array(
                    'inscrits' => $inscrit,
                    'link' => $link,
                    'J' => $J,
                    'D' => $D,
                    'jihas' => $jihas));
    }

    public function statWAction(Request $request) {

        $em = $this->getDoctrine()->getManager();
        $link = $em->getRepository('DbBundle:Link')->findOneBy(array('id'=> $request->get('id')));

        $stats = array();
        $statsK = array();
        $query = $em->createQuery("select p from DbBundle\Entity\Jiha p where p.id <25 ");
        $jihas = $query->getResult();

        $query = $em->createQuery("select p from DbBundle\Entity\Kesm p where p.id <8 ");
        $kesms = $query->getResult();


        foreach ($kesms as $kesm) {
            $inscrits = $em->getRepository('DbBundle:Inscrit')->findByKesmAcceptF(array('idKesm' => $kesm->getId(),'idLink' => $link->getId()));
            $statsK[$kesm->getId()]['total'] = count($inscrits);
            $statsK[$kesm->getId()]['tamhidiya'] = 0;
            $statsK[$kesm->getId()]['chara'] = 0;
            $statsK[$kesm->getId()]['name'] = $kesm->getNom();

            foreach ($inscrits as $inscrit) {
                if ($inscrit->getidDirassa()->getId() == 2) {
                    $statsK[$kesm->getId()]['tamhidiya'] = $statsK[$kesm->getId()]['tamhidiya'] + 1;
                } else {
                    $statsK[$kesm->getId()]['chara'] = $statsK[$kesm->getId()]['chara'] + 1;
                }
            }
        }
        foreach ($jihas as $jiha) {
            $inscrits = $em->getRepository('DbBundle:Inscrit')->findByJihaAcceptF(array('idJiha' => $jiha->getId(),'idLink' => $link->getId()));
            $stats[$jiha->getId()]['total'] = count($inscrits);
            $stats[$jiha->getId()]['tamhidiya'] = 0;
            $stats[$jiha->getId()]['TA'] = 0;
            $stats[$jiha->getId()]['TACH'] = 0;
            $stats[$jiha->getId()]['TZ'] = 0;
            $stats[$jiha->getId()]['TK'] = 0;
            $stats[$jiha->getId()]['TM'] = 0;
            $stats[$jiha->getId()]['TJ'] = 0;
            $stats[$jiha->getId()]['TD'] = 0;
            $stats[$jiha->getId()]['chara'] = 0;
            $stats[$jiha->getId()]['CHA'] = 0;
            $stats[$jiha->getId()]['CHACH'] = 0;
            $stats[$jiha->getId()]['CHZ'] = 0;
            $stats[$jiha->getId()]['CHK'] = 0;
            $stats[$jiha->getId()]['CHM'] = 0;
            $stats[$jiha->getId()]['CHJ'] = 0;
            $stats[$jiha->getId()]['CHD'] = 0;
            $stats[$jiha->getId()]['home'] = 0;
            $stats[$jiha->getId()]['femme'] = 0;
            $stats[$jiha->getId()]['name'] = $jiha->getName();

            foreach ($inscrits as $inscrit) {
                if ($inscrit->getidDirassa()->getId() == 2) {
                    $stats[$jiha->getId()]['tamhidiya'] = $stats[$jiha->getId()]['tamhidiya'] + 1;
                    if ($inscrit->getIdChef()->getidKesm()->getId() == 1) {
                        $stats[$jiha->getId()]['TA'] = $stats[$jiha->getId()]['TA'] + 1;
                    } elseif ($inscrit->getIdChef()->getidKesm()->getId() == 2) {
                        $stats[$jiha->getId()]['TACH'] = $stats[$jiha->getId()]['TACH'] + 1;
                    } elseif ($inscrit->getIdChef()->getidKesm()->getId() == 3) {
                        $stats[$jiha->getId()]['TZ'] = $stats[$jiha->getId()]['TZ'] + 1;
                    } elseif ($inscrit->getIdChef()->getidKesm()->getId() == 4) {
                        $stats[$jiha->getId()]['TK'] = $stats[$jiha->getId()]['TK'] + 1;
                    } elseif ($inscrit->getIdChef()->getidKesm()->getId() == 5) {
                        $stats[$jiha->getId()]['TM'] = $stats[$jiha->getId()]['TM'] + 1;
                    } elseif ($inscrit->getIdChef()->getidKesm()->getId() == 6) {
                        $stats[$jiha->getId()]['TJ'] = $stats[$jiha->getId()]['TJ'] + 1;
                    } elseif ($inscrit->getIdChef()->getidKesm()->getId() == 7) {
                        $stats[$jiha->getId()]['TD'] = $stats[$jiha->getId()]['TD'] + 1;
                    } else {
                        
                    }
                } else {
                    $stats[$jiha->getId()]['chara'] = $stats[$jiha->getId()]['chara'] + 1;
                    if ($inscrit->getIdChef()->getidKesm()->getId() == 1) {
                        $stats[$jiha->getId()]['CHA'] = $stats[$jiha->getId()]['CHA'] + 1;
                    } elseif ($inscrit->getIdChef()->getidKesm()->getId() == 2) {
                        $stats[$jiha->getId()]['CHACH'] = $stats[$jiha->getId()]['CHACH'] + 1;
                    } elseif ($inscrit->getIdChef()->getidKesm()->getId() == 3) {
                        $stats[$jiha->getId()]['CHZ'] = $stats[$jiha->getId()]['CHZ'] + 1;
                    } elseif ($inscrit->getIdChef()->getidKesm()->getId() == 4) {
                        $stats[$jiha->getId()]['CHK'] = $stats[$jiha->getId()]['CHK'] + 1;
                    } elseif ($inscrit->getIdChef()->getidKesm()->getId() == 5) {
                        $stats[$jiha->getId()]['CHM'] = $stats[$jiha->getId()]['CHM'] + 1;
                    } elseif ($inscrit->getIdChef()->getidKesm()->getId() == 6) {
                        $stats[$jiha->getId()]['CHJ'] = $stats[$jiha->getId()]['CHJ'] + 1;
                    } elseif ($inscrit->getIdChef()->getidKesm()->getId() == 7) {
                        $stats[$jiha->getId()]['CHD'] = $stats[$jiha->getId()]['CHD'] + 1;
                    } else {
                        
                    }
                }

                if ($inscrit->getIdChef()->getSex() == 2) {
                    $stats[$jiha->getId()]['femme'] = $stats[$jiha->getId()]['femme'] + 1;
                } else {
                    $stats[$jiha->getId()]['home'] = $stats[$jiha->getId()]['home'] + 1;
                }
            }
        }



        return $this->render('DirasetBundle:adminInscrit:statW.html.twig', array(
                    'stats' => $stats,
                    'statsK' => $statsK,
            'link' => $link,
        ));
    }
    
    public function statAction(Request $request) {

        $em = $this->getDoctrine()->getManager();
        $link = $em->getRepository('DbBundle:Link')->findOneBy(array('id'=> $request->get('id')));

        $stats = array();
        $statsK = array();
        $query = $em->createQuery("select p from DbBundle\Entity\Jiha p where p.id <25 ");
        $jihas = $query->getResult();

        $query = $em->createQuery("select p from DbBundle\Entity\Kesm p where p.id <8 ");
        $kesms = $query->getResult();

        foreach ($kesms as $kesm) {
            $inscrits = $em->getRepository('DbBundle:Inscrit')->findByKesm(array('idKesm' => $kesm->getId(),'idLink' => $link->getId()));
            $statsK[$kesm->getId()]['total'] = count($inscrits);
            $statsK[$kesm->getId()]['tamhidiya'] = 0;
            $statsK[$kesm->getId()]['chara'] = 0;
            $statsK[$kesm->getId()]['name'] = $kesm->getNom();

            foreach ($inscrits as $inscrit) {
                if ($inscrit->getidDirassa()->getId() == 2) {
                    $statsK[$kesm->getId()]['tamhidiya'] = $statsK[$kesm->getId()]['tamhidiya'] + 1;
                } else {
                    $statsK[$kesm->getId()]['chara'] = $statsK[$kesm->getId()]['chara'] + 1;
                }
            }
        }

        foreach ($jihas as $jiha) {
            $inscrits = $em->getRepository('DbBundle:Inscrit')->findByJiha(array('idJiha' => $jiha->getId(), 'idLink' => $link->getId()));
            $stats[$jiha->getId()]['total'] = count($inscrits);
            $stats[$jiha->getId()]['tamhidiya'] = 0;
            $stats[$jiha->getId()]['TA'] = 0;
            $stats[$jiha->getId()]['TACH'] = 0;
            $stats[$jiha->getId()]['TZ'] = 0;
            $stats[$jiha->getId()]['TK'] = 0;
            $stats[$jiha->getId()]['TM'] = 0;
            $stats[$jiha->getId()]['TJ'] = 0;
            $stats[$jiha->getId()]['TD'] = 0;
            $stats[$jiha->getId()]['chara'] = 0;
            $stats[$jiha->getId()]['CHA'] = 0;
            $stats[$jiha->getId()]['CHACH'] = 0;
            $stats[$jiha->getId()]['CHZ'] = 0;
            $stats[$jiha->getId()]['CHK'] = 0;
            $stats[$jiha->getId()]['CHM'] = 0;
            $stats[$jiha->getId()]['CHJ'] = 0;
            $stats[$jiha->getId()]['CHD'] = 0;
            $stats[$jiha->getId()]['home'] = 0;
            $stats[$jiha->getId()]['femme'] = 0;
            $stats[$jiha->getId()]['name'] = $jiha->getName();

            foreach ($inscrits as $inscrit) {
                if ($inscrit->getidDirassa()->getId() == 2) {
                    $stats[$jiha->getId()]['tamhidiya'] = $stats[$jiha->getId()]['tamhidiya'] + 1;
                    if ($inscrit->getIdChef()->getIdKesm()->getId() == 1) {
                        $stats[$jiha->getId()]['TA'] = $stats[$jiha->getId()]['TA'] + 1;
                    } elseif ($inscrit->getIdChef()->getIdKesm()->getId() == 2) {
                        $stats[$jiha->getId()]['TACH'] = $stats[$jiha->getId()]['TACH'] + 1;
                    } elseif ($inscrit->getIdChef()->getIdKesm()->getId() == 3) {
                        $stats[$jiha->getId()]['TZ'] = $stats[$jiha->getId()]['TZ'] + 1;
                    } elseif ($inscrit->getIdChef()->getIdKesm()->getId() == 4) {
                        $stats[$jiha->getId()]['TK'] = $stats[$jiha->getId()]['TK'] + 1;
                    } elseif ($inscrit->getIdChef()->getIdKesm()->getId() == 5) {
                        $stats[$jiha->getId()]['TM'] = $stats[$jiha->getId()]['TM'] + 1;
                    } elseif ($inscrit->getIdChef()->getIdKesm()->getId() == 6) {
                        $stats[$jiha->getId()]['TJ'] = $stats[$jiha->getId()]['TJ'] + 1;
                    } elseif ($inscrit->getIdChef()->getIdKesm()->getId() == 7) {
                        $stats[$jiha->getId()]['TD'] = $stats[$jiha->getId()]['TD'] + 1;
                    } else {
                        
                    }
                } else {
                    $stats[$jiha->getId()]['chara'] = $stats[$jiha->getId()]['chara'] + 1;
                    if ($inscrit->getIdChef()->getIdKesm()->getId() == 1) {
                        $stats[$jiha->getId()]['CHA'] = $stats[$jiha->getId()]['CHA'] + 1;
                    } elseif ($inscrit->getIdChef()->getIdKesm()->getId() == 2) {
                        $stats[$jiha->getId()]['CHACH'] = $stats[$jiha->getId()]['CHACH'] + 1;
                    } elseif ($inscrit->getIdChef()->getIdKesm()->getId() == 3) {
                        $stats[$jiha->getId()]['CHZ'] = $stats[$jiha->getId()]['CHZ'] + 1;
                    } elseif ($inscrit->getIdChef()->getIdKesm()->getId() == 4) {
                        $stats[$jiha->getId()]['CHK'] = $stats[$jiha->getId()]['CHK'] + 1;
                    } elseif ($inscrit->getIdChef()->getIdKesm()->getId() == 5) {
                        $stats[$jiha->getId()]['CHM'] = $stats[$jiha->getId()]['CHM'] + 1;
                    } elseif ($inscrit->getIdChef()->getIdKesm()->getId() == 6) {
                        $stats[$jiha->getId()]['CHJ'] = $stats[$jiha->getId()]['CHJ'] + 1;
                    } elseif ($inscrit->getIdChef()->getIdKesm()->getId() == 7) {
                        $stats[$jiha->getId()]['CHD'] = $stats[$jiha->getId()]['CHD'] + 1;
                    } else {
                        
                    }
                }

                if ($inscrit->getIdChef()->getSex() == 2) {
                    $stats[$jiha->getId()]['femme'] = $stats[$jiha->getId()]['femme'] + 1;
                } else {
                    $stats[$jiha->getId()]['home'] = $stats[$jiha->getId()]['home'] + 1;
                }
            }
        }


        
        return $this->render('DirasetBundle:adminInscrit:statW.html.twig', array(
                    'stats' => $stats,
                    'statsK' => $statsK,
                    'link' => $link,
        ));
    }

    public function stat2WAction(Request $request) {

        $em = $this->getDoctrine()->getManager();
        $link = $em->getRepository('DbBundle:Link')->findOneBy(array('id'=> $request->get('id')));

        $stats = array();
        $statsK = array();
        $query = $em->createQuery("select p from DbBundle\Entity\Jiha p where p.id <25 ");
        $jihas = $query->getResult();

        $query = $em->createQuery("select p from DbBundle\Entity\Kesm p where p.id <8 ");
        $kesms = $query->getResult();


        foreach ($kesms as $kesm) {
            $inscrits = $em->getRepository('DbBundle:Inscrit')->findByKesmAccept(array('idKesm' => $kesm->getId(), 'accepteW' => 1,'idLink' => $link->getId()));
            $statsK[$kesm->getId()]['total'] = count($inscrits);
            $statsK[$kesm->getId()]['tamhidiya'] = 0;
            $statsK[$kesm->getId()]['chara'] = 0;
            $statsK[$kesm->getId()]['name'] = $kesm->getNom();

            foreach ($inscrits as $inscrit) {
                if ($inscrit->getidDirassa()->getId() == 2) {
                    $statsK[$kesm->getId()]['tamhidiya'] = $statsK[$kesm->getId()]['tamhidiya'] + 1;
                } else {
                    $statsK[$kesm->getId()]['chara'] = $statsK[$kesm->getId()]['chara'] + 1;
                }
            }
        }
        foreach ($jihas as $jiha) {
            $inscrits = $em->getRepository('DbBundle:Inscrit')->findByJihaAccept(array('idJiha' => $jiha->getId(), 'accepteW' => 1,'idLink' => $link->getId()));
            $stats[$jiha->getId()]['total'] = count($inscrits);
            $stats[$jiha->getId()]['tamhidiya'] = 0;
            $stats[$jiha->getId()]['TA'] = 0;
            $stats[$jiha->getId()]['TACH'] = 0;
            $stats[$jiha->getId()]['TZ'] = 0;
            $stats[$jiha->getId()]['TK'] = 0;
            $stats[$jiha->getId()]['TM'] = 0;
            $stats[$jiha->getId()]['TJ'] = 0;
            $stats[$jiha->getId()]['TD'] = 0;
            $stats[$jiha->getId()]['chara'] = 0;
            $stats[$jiha->getId()]['CHA'] = 0;
            $stats[$jiha->getId()]['CHACH'] = 0;
            $stats[$jiha->getId()]['CHZ'] = 0;
            $stats[$jiha->getId()]['CHK'] = 0;
            $stats[$jiha->getId()]['CHM'] = 0;
            $stats[$jiha->getId()]['CHJ'] = 0;
            $stats[$jiha->getId()]['CHD'] = 0;
            $stats[$jiha->getId()]['home'] = 0;
            $stats[$jiha->getId()]['femme'] = 0;
            $stats[$jiha->getId()]['name'] = $jiha->getName();

            foreach ($inscrits as $inscrit) {
                if ($inscrit->getidDirassa()->getId() == 2) {
                    $stats[$jiha->getId()]['tamhidiya'] = $stats[$jiha->getId()]['tamhidiya'] + 1;
                    if ($inscrit->getIdChef()->getIdKesm()->getId() == 1) {
                        $stats[$jiha->getId()]['TA'] = $stats[$jiha->getId()]['TA'] + 1;
                    } elseif ($inscrit->getIdChef()->getIdKesm()->getId() == 2) {
                        $stats[$jiha->getId()]['TACH'] = $stats[$jiha->getId()]['TACH'] + 1;
                    } elseif ($inscrit->getIdChef()->getIdKesm()->getId() == 3) {
                        $stats[$jiha->getId()]['TZ'] = $stats[$jiha->getId()]['TZ'] + 1;
                    } elseif ($inscrit->getIdChef()->getIdKesm()->getId() == 4) {
                        $stats[$jiha->getId()]['TK'] = $stats[$jiha->getId()]['TK'] + 1;
                    } elseif ($inscrit->getIdChef()->getIdKesm()->getId() == 5) {
                        $stats[$jiha->getId()]['TM'] = $stats[$jiha->getId()]['TM'] + 1;
                    } elseif ($inscrit->getIdChef()->getIdKesm()->getId() == 6) {
                        $stats[$jiha->getId()]['TJ'] = $stats[$jiha->getId()]['TJ'] + 1;
                    } elseif ($inscrit->getIdChef()->getIdKesm()->getId() == 7) {
                        $stats[$jiha->getId()]['TD'] = $stats[$jiha->getId()]['TD'] + 1;
                    } else {
                        
                    }
                } else {
                    $stats[$jiha->getId()]['chara'] = $stats[$jiha->getId()]['chara'] + 1;
                    if ($inscrit->getIdChef()->getIdKesm()->getId() == 1) {
                        $stats[$jiha->getId()]['CHA'] = $stats[$jiha->getId()]['CHA'] + 1;
                    } elseif ($inscrit->getIdChef()->getIdKesm()->getId() == 2) {
                        $stats[$jiha->getId()]['CHACH'] = $stats[$jiha->getId()]['CHACH'] + 1;
                    } elseif ($inscrit->getIdChef()->getIdKesm()->getId() == 3) {
                        $stats[$jiha->getId()]['CHZ'] = $stats[$jiha->getId()]['CHZ'] + 1;
                    } elseif ($inscrit->getIdChef()->getIdKesm()->getId() == 4) {
                        $stats[$jiha->getId()]['CHK'] = $stats[$jiha->getId()]['CHK'] + 1;
                    } elseif ($inscrit->getIdChef()->getIdKesm()->getId() == 5) {
                        $stats[$jiha->getId()]['CHM'] = $stats[$jiha->getId()]['CHM'] + 1;
                    } elseif ($inscrit->getIdChef()->getIdKesm()->getId() == 6) {
                        $stats[$jiha->getId()]['CHJ'] = $stats[$jiha->getId()]['CHJ'] + 1;
                    } elseif ($inscrit->getIdChef()->getIdKesm()->getId() == 7) {
                        $stats[$jiha->getId()]['CHD'] = $stats[$jiha->getId()]['CHD'] + 1;
                    } else {
                        
                    }
                }

                if ($inscrit->getIdChef()->getSex() == 2) {
                    $stats[$jiha->getId()]['femme'] = $stats[$jiha->getId()]['femme'] + 1;
                } else {
                    $stats[$jiha->getId()]['home'] = $stats[$jiha->getId()]['home'] + 1;
                }
            }
        }



        return $this->render('DirasetBundle:adminInscrit:statW.html.twig', array(
                    'stats' => $stats,
                    'statsK' => $statsK,
                    'link' => $link,
        ));
    }

    public function accepterJAction(Request $request) {

        $em = $this->getDoctrine()->getManager();
        $privilege = $em->getRepository('DbBundle:Privilaige')->findOneBy(array("actif" => 1, "idUser" => $this->get('security.context')->getToken()->getUser()->getId()));
        $link = $em->getRepository('DbBundle:Link')->findOneBy(array('id'=> $request->get('idLink')));

        $inscrit = $em->getRepository('DbBundle:Inscrit')->findByJiha(array("idJiha" => $privilege->getIdJiha()->getId(),'idLink' => $link->getId() ));

        if ($request->getMethod() == 'POST' || $request->get('id')) {
            $Ins = $em->getRepository('DbBundle:Inscrit')->findOneBy(array('id' => $request->get('id')));
            if ($request->get('etat') == 'oui') {
                $Ins->setAccepteJ(1);
            } else {
                $Ins->setAccepteJ(2);
                $Ins->setAccepteMessageJ($request->get('raison'));
                $Ins->setPaye(null);
            }
            $em->merge($Ins);
            $em->flush();
            return $this->render('DirasetBundle:adminInscrit:accepterJ.html.twig', array(
                        'inscrits' => $inscrit,
                        'link' => $link
            ));
        }



        return $this->render('DirasetBundle:adminInscrit:accepterJ.html.twig', array(
                    'inscrits' => $inscrit,
                    'link' => $link
            ));
    }

    public function payeAction(Request $request) {

        $em = $this->getDoctrine()->getManager();
        $link = $em->getRepository('DbBundle:Link')->findOneBy(array('id'=> $request->get('idLink')));

        $Ins = $em->getRepository('DbBundle:Inscrit')->findOneBy(array('id' => $request->get('id')));
        if ($request->get('etat') == 'oui') {
            $Ins->setPaye(1);
        } else {
            $Ins->setPaye(2);
        }
        $em->merge($Ins);
        $em->flush();
        
        if($request->get('Jiha') != NULL && $request->get('Jiha') == 'oui'){
                    return $this->redirectToRoute('adminInscrit_accepterJ',array('id' => $link->getId()));

        }else{
                    return $this->redirectToRoute('adminInscrit_accepterW',array('jiha'=>$request->get('J'), 'Dirassa'=>$request->get('D'), 'idLink' =>$link->getId()));

        }
    }

    public function presenceAction(Request $request) {

        $em = $this->getDoctrine()->getManager();

        $Ins = $em->getRepository('DbBundle:Inscrit')->findOneBy(array('id' => $request->get('id')));
        if ($request->get('etat') == 'oui') {
            $Ins->setPresence(1);
        } else {
            $Ins->setPresence(2);
        }
        $em->merge($Ins);
        $em->flush();
        return $this->redirectToRoute('inscrit_Dawra', array('dawra' => $request->get('idDawra'), 'psw' => $request->get('psw'), 'nom' => $request->get('login')));
    }

    public function tahilAction(Request $request) {

        $em = $this->getDoctrine()->getManager();

        $Ins = $em->getRepository('DbBundle:Inscrit')->findOneBy(array('id' => $request->get('id')));
        if ($request->get('etat') == 'oui') {
            $Ins->setResult(1);
        } else {
            $Ins->setResult(2);
        }
        $em->merge($Ins);
        $em->flush();
        return $this->redirectToRoute('inscrit_Dawra', array('dawra' => $request->get('idDawra'), 'psw' => $request->get('psw'), 'nom' => $request->get('login')));
    }

    /**
     * Creates a form to delete a inscrit entity.
     *
     * @param Inscrit $inscrit The inscrit entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Inscrit $inscrit) {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('inscrit_delete', array('id' => $inscrit->getId())))
                        ->setMethod('DELETE')
                        ->getForm()
        ;
    }

    public function attribCharaAction(Request $request) {

        $em = $this->getDoctrine()->getManager();
        $link = $em->getRepository('DbBundle:Link')->findOneBy(array('id'=> $request->get('id')));

        $J = null;
        $D = null;

        if ($request->get('jiha') != NULL) {
            $J = $request->get('jiha');
        }
        if ($request->get('kesm') != NULL ) {
            $D = $request->get('kesm');
        }

        $inscrit = $em->getRepository('DbBundle:Inscrit')->findByAcceptWatani2(array('jiha'=>$J, 'kesm'=>$D,'idLink' =>$link->getId()));
        $dawrat = $em->getRepository('DbBundle:DawraTadrib')->findBy(array("idLink" => $link->getId()));


        return $this->render('DirasetBundle:adminInscrit:attribChara.html.twig', array(
                    'inscrits' => $inscrit,
                    'dawrats' => $dawrat,
                    'link' => $link,
                    'J' => $J,
                    'D' => $D,
        ));
    }

    public function attribTamhidiyaAction(Request $request) {

        $em = $this->getDoctrine()->getManager();

        $condition = "";
        $J = "";
        $D = "";

        if ($request->get('jiha') != NULL) {
            $J = $request->get('jiha');
            $condition = $condition . " AND p.idJiha ='" . $request->get('jiha') . "'";
        }
        if ($request->get('kesm') != NULL) {
            $D = $request->get('kesm');
            $condition = $condition . " AND p.idKesm ='" . $request->get('kesm') . "'";
        }


        $query = $em->createQuery("select p from DbBundle\Entity\Inscrit p where p.idDirassa = 2 AND p.accepteW = 1  AND p.paye = 1 " . $condition);
        $inscrit = $query->getResult();
        $dawrat = $em->getRepository('DbBundle:DawraTadrib')->findBy(array("idAtributType" => 2));


        $jihas = $em->getRepository('DbBundle:Jiha')->findAll();

        $query2 = $em->createQuery("select p from DbBundle\Entity\Kesm p where p.id > 1 AND p.id < 8");
        $kesms = $query2->getResult();
        return $this->render('DirasetBundle:adminInscrit:attribTamhidiya.html.twig', array(
                    'inscrits' => $inscrit,
                    'dawrats' => $dawrat,
                    'kesms' => $kesms,
                    'J' => $J,
                    'D' => $D,
                    'jihas' => $jihas,
        ));
    }

    public function attribAction(Request $request) {

        $em = $this->getDoctrine()->getManager();

        $inscrit = $em->getRepository('DbBundle:Inscrit')->findOneBy(array("id" => $request->get('idU')));
        $dawrat = $em->getRepository('DbBundle:DawraTadrib')->findOneBy(array("id" => $request->get('idD')));

        $inscrit->setIdDirassaA($dawrat);
        $inscrit->setIdMarkez($dawrat->getIdMarkez());

        $em->merge($inscrit);
        $em->flush();

        if ($request->get('type') == 'CH') {
            return $this->redirectToRoute('adminInscrit_attribChara', array('kesm' => $request->get('kesm'), 'jiha' => $request->get('jiha'),'id' => $request->get('idLink')));
        } else {
            return $this->redirectToRoute('adminInscrit_attribTamhidiya', array('kesm' => $request->get('kesm'), 'jiha' => $request->get('jiha'),'id' => $request->get('idLink')));
        }
    }

}
