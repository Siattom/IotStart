<?php

namespace App\Controller;

use App\Entity\Intervention;
use App\Entity\Rapport;
use App\Form\AffectFinalType;
use App\Form\RapportType;
use App\Repository\InterventionRepository;
use App\Repository\OperateurRepository;
use App\Repository\RapportRepository;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/ope")
 */
class OperateurController extends AbstractController
{
    /**
     * @Route("/operateur", name="app_operateur")
     */
    public function index(): Response
    {
        return $this->render('operateur/index.html.twig', [
            'controller_name' => 'OperateurController',
            'multiple'  => true,
            'expanded' => true,
        ]);
    }

    /**
     * @Route("/add/rapport/{id}", name="add_rapport", methods={"GET", "POST"}, requirements={"id"="\d+"})
     */
    public function addRapport(Int $id, Request $request, EntityManagerInterface $entityManager, ManagerRegistry $doctrine , InterventionRepository $interventionRepository): Response
    {
      $rapport = new Rapport();
      $entityManager = $doctrine->getManager();
      $intervention = $entityManager->getRepository(Intervention::class)->find($id);
      $form = $this->createForm(RapportType::class, $rapport);
      $form->handleRequest($request);

      if ($form->isSubmitted() && $form->isValid()) {
         $rapport->setCreatedAt(new DateTimeImmutable());
         //$rapport->setUser($this->getUser());

         //dd($rapport->setUser());
         $rapport->setIntervention($entityManager->getRepository(Intervention::class)->find($id));
         $entityManager->persist($rapport);
         $entityManager->flush();

         return $this->redirectToRoute('first');
      }

      return $this->render('rapport/rapportAdd.html.twig', [
          'rapportForm' => $form->createView(),
          'id' => $intervention
      ]);
    }

    /**
     * @Route("/rapport/list/{id}", name="rapport_list",requirements={"id"="\d+"})
     * @return Response
     */
    public function rapportList(Int $id, InterventionRepository $interventionRepository, EntityManagerInterface $entityManager, RapportRepository $rapportRepository){

        $interventionId = $entityManager->getRepository(Intervention::class)->find($id);
        $rapportInfo = $rapportRepository->findById($id);

        return $this->render('rapport/list.html.twig', [
            'id' => $interventionId,
            'rapport' => $rapportInfo
        ]
        );
    }


    /**
     * @Route("/cloture/{id}", name="cloture")
     */
    public function clotureRapport(Int $id, EntityManagerInterface $entityManager, Intervention $intervention){
        
        $interventionInfo = $entityManager->getRepository(Intervention::class)->find($id);

        $cloture = $interventionInfo;
        $cloture->setCloture('1');
        $entityManager->persist($intervention);
        $entityManager->flush();

        return $this->redirectToRoute('first');
    }
}