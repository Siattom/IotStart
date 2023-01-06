<?php

namespace App\Controller;

use DateTime;
use DateTimeImmutable;
use App\Entity\Rapport;
use App\Entity\Securite;
use App\Entity\Operateur;
use App\Entity\Intervention;
use App\Form\AffectFinalType;
use App\Form\InterventionType;
use App\Repository\ClientRepository;
use App\Form\InterventionAffectType;
use App\Repository\RapportRepository;
use App\Repository\SecuriteRepository;
use App\Form\InterventionSecuriteType;
use App\Repository\OperateurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\InterventionRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/inter")
 */
class InterventionController extends AbstractController
{
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
            // le n°Ot est mit à 000000000 pour etre modifié à l'avenir
            $intervention->setCloture('0');
            // On précise que l'intervention n'est pas cloturée
            $intervention->setStartWork(new DateTime());
            // L'intervention démarre à sa création pour le moment (point à revoir)

            $entityManager->persist($intervention);
            $entityManager->flush();
            // on pousseintervention->redirectToRoute('intervention_add');
            // on redirige vers cette route une fois le formulaire remplie

            return $this->redirectToRoute('intervention_list');
        }

            return $this->render('rapport/interventionAdd.html.twig', [
                'intervention' =>$form->createView(),
                // quand le formulaire n'est pas encore remplie on sera redirigé vers la route de formulaire
            ]);
    }

    
    /**
    * @Route("/intervention/add/{id}", name="intervention_add_securite")
    */
    public function interventionAddBySecurite(Int $id, Request $request,Securite $securiteEntity, EntityManagerInterface $entityManager, SecuriteRepository $securiteRepository)
    {
        $securite = $securiteRepository->findSecuriteById($id);
        $client = $securiteRepository->findClient($id);
        $intervention = new Intervention();
        $form = $this->createForm(InterventionSecuriteType::class, $intervention);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $intervention->setCreatedAt(new DateTimeImmutable());
            $intervention->setN°ot('0000000000');
            $intervention->setCloture('0');
            $intervention->setStartWork(new DateTime());
            $intervention->setClient($client[0]);
            $securiteEntity->setStatut('1');

            $entityManager->persist($intervention);
            $entityManager->flush();

            return $this->redirectToRoute('intervention_list');
        }

            return $this->render('rapport/interventionAddBySecurite.html.twig', [
                'intervention' => $form->createView(),
                'securite' => $securite,
            ]);
    }


    /**
     * @Route("/intervention/list", name="intervention_list")
     */
    public function interventionList(InterventionRepository $InterventionRepository, RapportRepository $rapportRepository)
    {
        $interventionId = $InterventionRepository->findAll();
        $rapport = $rapportRepository->findAll();
        
            return $this->render('/intervention/inter.html.twig', [
                'interventions' => $interventionId,
                'rapport' => $rapport,
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
    * @Route("/intervention/affect/{id}", name="intervention_affect_ope", requirements={"id"="\d+"}, methods={"GET", "POST"})
    */
    public function interventionAffect(EntityManagerInterface $entityManager, Request $request, Intervention $intervention, RapportRepository $rapportRepository)
    {
        $form = $this->createForm(InterventionAffectType::class, $intervention);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager->persist($intervention);
            $entityManager->flush();
            
            return $this->redirectToRoute('intervention_list');
        }

            return $this->render('intervention/inter-ope.html.twig', [
                'form' => $form->createView(),
                'intervention' => $intervention,
            ]);
    }


    /** 
     * @Route("/securite/list", name="securite_list")
     */
    public function securiteList(SecuriteRepository $securiteRepository)
    {
        $securite = $securiteRepository->findAll();

            return $this->render('intervention/securite-list.html.twig', [
                'securite' => $securite,
            ]);
    }  


    /**
     * @Route("/list/securite/asc", name="list_securite_asc", methods="GET")
     */
    public function listSecuriteAsc(SecuriteRepository $securiteRepository)
    {
        $securite = $securiteRepository->findSecuriteAsc();

        return $this->render('intervention/securite-list.html.twig', [
            'securite' => $securite,
        ]);
    }


    /**
     * @Route("/list/securite/desc", name="list_securite_desc", methods="GET")
     */
    public function listSecuriteDesc(SecuriteRepository $securiteRepository)
    {
        $securite = $securiteRepository->findSecuriteDesc();

        return $this->render('intervention/securite-list.html.twig', [
            'securite' => $securite,
        ]);
    }


    /**
     * @Route("/list/securite/oui", name="list_securite_oui", methods="GET")
     */
    public function listSecuriteOui(SecuriteRepository $securiteRepository)
    {
        $securite = $securiteRepository->findSecuriteOui();

        return $this->render('intervention/securite-list.html.twig', [
            'securite' => $securite,
        ]);
    }


    /**
     * @Route("/list/securite/non", name="list_securite_non", methods="GET")
     */
    public function listSecuriteNon(SecuriteRepository $securiteRepository)
    {
        $securite = $securiteRepository->findSecuriteNon();

        return $this->render('intervention/securite-list.html.twig', [
            'securite' => $securite,
        ]);
    }



     /**
     * All intervention by client list
     * And Search
     * 
     * @Route("/client/search", name="client_search")
     */
    public function list(InterventionRepository $InterventionRepository, Request $request)
    {
        // On va chercher les données
        $clientList = $InterventionRepository->findAllOrderedByClientAscQb($request->query->get('search'));
    
        return $this->render('intervention/inter-found.html.twig', [
                'clientList' => $clientList,
            ]);
    }

    /**
     * @Route("/list/intervention/cloture/non", name="list_intervention_cloture_non", methods="GET")
     */
    public function listInterventionClotureNon(InterventionRepository $InterventionRepository)
    {
        $clientList = $InterventionRepository->findInterventionClotureNon();

        return $this->render('intervention/inter-found.html.twig', [
            'clientList' => $clientList,
        ]);
    }


    /**
     * @Route("/list/intervention/cloture", name="list_intervention_cloture", methods="GET")
     */
    public function listInterventionCloture(InterventionRepository $InterventionRepository)
    {
        $clientList = $InterventionRepository->findInterventionCloture();

        return $this->render('intervention/inter-found.html.twig', [
            'clientList' => $clientList,
        ]);
    }
}