<?php

namespace App\Controller;

use App\Entity\Intervention;
use App\Entity\Operateur;
use App\Entity\Rapport;
use App\Form\AffectFinalFinalType;
use App\Form\AffectFinalType;
use App\Form\InterventionAffectType;
use App\Form\InterventionType;
use App\Repository\InterventionRepository;
use App\Repository\OperateurRepository;
use App\Repository\RapportRepository;
use DateTime;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/inter")
 */
class InterventionController extends AbstractController
{
//    /**
//     * page qui va afficher les rapports non remplies
//     * @Route("/rapport/empty", name="rapport_empty", methods="GET")
//     * @return Response
//     */
//    public function showEmptyRapport(Int $id, ManagerRegistry $doctrine, RapportRepository $rapportRepository)
//    {
//        // prepare data
//        $entityManager = $doctrine->getManager();
//        $rapport = $entityManager->getRepository(Rapport::class)->find($id);
//        $emptyRapport = $rapportRepository->findInt($id);
//        
//        return $this->render('rapport/rapports.html.twig', [
//        //'id' => $operateur,
//        /* 'adresse' => $valeur, */
//        //'interventions' => $allIntOpe,
//        ]);
//    }

    /**
     * @Route("/intervention/add", name="intervention_add")
     */
    public function inerventionAdd(Request $request, EntityManagerInterface $entityManager)
    {
        $intervention = new Intervention();
        $form = $this->createForm(InterventionType::class, $intervention);
        $form->handleRequest($request);
        // on associe l'entité intervention pour avoir accès aux informations

        if ($form->isSubmitted() && $form->isValid()) {
            $intervention->setCreatedAt(new DateTimeImmutable());
            // on fournit la date de création de l'intervention
            $intervention->setN°ot('0000000000');
            // le n°Ot est mit à 000000000 pour etre modifié à l'avenir
            $intervention->setCloture('0');
            // On précise que l'intervention n'est pas cloturée
            $intervention->setStartWork(new DateTime());
            // L'intervention démarre à sa création pour le moment (point à revoir)

            $entityManager->persist($intervention);
            $entityManager->flush();
            // on pousse en base de données

            return $this->redirectToRoute('intervention_add');
            // on redirige vers cette route une fois le formulaire remplie
        }

        return $this->render('rapport/interventionAdd.html.twig', [
            'intervention' =>$form->createView(),
            // quand le formulaire n'est pas encore remplie on sera redirigé vers la route de formulaire
        ]);
    }

    /**
     * @Route("/intervention/list", name="intervention_list")
     */
    public function interventionList(InterventionRepository $InterventionRepository)
    {
        $interventionId = $InterventionRepository->findAll();
        
        return $this->render ('/intervention/inter.html.twig', [
            'interventions' => $interventionId,
        ]);
    }

     /**
     * @Route("/intervention/edit/{id}", name="intervention_edit", methods={"GET", "POST"})
     */
    public function edit(Int $id, Request $request, Intervention $intervention, InterventionRepository $InterventionRepository, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(InterventionType::class, $intervention);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager->persist($intervention);
            $entityManager->flush();

            return $this->redirectToRoute('intervention_list');
        }

        return $this->render('rapport/interventionAdd.html.twig', [
            'intervention' =>$form->createView(),
        ]);
    }

    /**
    * @Route("/intervention/affect/{id}", name="intervention_affect_ope", requirements={"id"="\d+"})
    */
    public function interventionAffect(Request $request, Intervention $intervention, InterventionRepository $interventionRepository, EntityManagerInterface $entityManager, OperateurRepository $operateurRepository): Response
    {

        $interventions = $interventionRepository->findAll();
//        $operateur = $operateurRepository->findForInter();
        /* dd($operateur); */

        $form = $this->createForm(AffectFinalType::class, $intervention);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager->flush();


            $this->addFlash('operateur affecté', 'yes.');
            return $this->redirectToRoute('intervention_affect_ope', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('intervention/inter-ope.html.twig', [
            'intervention' => $intervention,
            'interventions' => $interventions,
//            'operateur' => $operateur,
            'form' => $form,
        ]);
    }
    }
