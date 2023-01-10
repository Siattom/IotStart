<?php

namespace App\Controller;

use DateTime;
use DateTimeImmutable;
use App\Form\VisiteType;
use App\Entity\Intervention;
use App\Entity\VisiteTechnique;
use App\Repository\OperateurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\InterventionRepository;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\VisiteTechniqueRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class VisiteTechniqueController extends CoreController
{
    /**
     * @Route("/vt/add", name="vt_add")
     */
    public function vtAdd(Request $request, OperateurRepository $operateurRepository, EntityManagerInterface $entityManager, ManagerRegistry $doctrine): Response
    {
        $user = $this->getUser()->getId();
        $operateurInfo = $operateurRepository->findUser($user);
        
        //dd($operateur);
        if ($operateurInfo == null) {
            $admin = $operateurRepository->findUser(4);
            $operateur = $admin[0];
        } else {
            $operateur = $operateurInfo[0];
            /* $ope = $operateur->getId(); */
        };
        

        $visite = new VisiteTechnique();
        $entityManager = $doctrine->getManager();
        $form = $this->createForm(VisiteType::class, $visite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $visite->setCreatedAt(new Datetime());
            $visite->setOperateur($operateur);

            $entityManager->persist($visite);
            $entityManager->flush();

            return $this->redirectToRoute('first');
        }

        return $this->render('visite/add.html.twig', [
            'visiteForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/add/vt/{id}", name="add_vt_id", methods={"GET", "POST"}, requirements={"id"="\d+"})
     */
    public function addVtId(Int $id, Request $request, EntityManagerInterface $entityManager, ManagerRegistry $doctrine, OperateurRepository $operateurRepository, InterventionRepository $interventionRepository): Response
    {
        $user = $this->getUser()->getId();
        $operateurInfo = $operateurRepository->findUser($user);
        $operateur = $operateurInfo[0];

        $visite = new VisiteTechnique();
        $entityManager = $doctrine->getManager();
        /* $intervention = $entityManager->getRepository(Intervention::class)->find($id); */
        $form = $this->createForm(VisiteType::class, $visite);
        $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $visite->setCreatedAt(new Datetime());
                $visite->setOperateur($operateur);
                $visite->setIntervention($entityManager->getRepository(Intervention::class)->find($id));

                $entityManager->persist($visite);
                $entityManager->flush();

                    return $this->redirectToRoute('first');
            }

                return $this->render('visite/add.html.twig', [
                    'visiteForm' => $form->createView(),
                ]);
    }


    /**
     * display list vt
     * @Route("/vt/list", name="vt_list", methods={"GET"})
     */
    public function vtList(VisiteTechniqueRepository $visiteTechniqueRepository) 
    {
        // il faut appeler la fonction qui recupere les vt
        $rapportVt = $visiteTechniqueRepository->findRapportVt();

        return $this->render('visite/list.html.twig', [
            'visites' => $rapportVt,
        ]);
    }


    /**
     * @Route("/vt/list/search", name="vt_list_search", methods="GET")
     */
    public function vtListSearch(VisiteTechniqueRepository $VisiteTechniqueRepository, Request $request)
    {
        // On va chercher les données
        $rapportVt = $VisiteTechniqueRepository->findAllOrderedByClientAscQb($request->query->get('search'));

        return $this->render('visite/list.html.twig', [
                'visites' => $rapportVt,
            ]);
            
    }


    /**
     * @Route("/vt/edit/{id}", name="vt_edit", methods={"GET", "POST"})
     */
    public function vtEdit(Int $id, Request $request, VisiteTechnique $visiteTechnique, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(VisiteType::class, $visiteTechnique);
        $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $visiteTechnique->setUpdatedAt(new Datetime());

                $entityManager->persist($visiteTechnique);
                $entityManager->flush();

                    return $this->redirectToRoute('vt_list');
            }

        return $this->render('visite/add.html.twig', [
            'visiteForm' => $form->createView(),
        ]);
    }
}