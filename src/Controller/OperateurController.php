<?php

namespace App\Controller;

use DateTimeImmutable;
use App\Entity\Rapport;
use App\Form\RapportType;
use App\Entity\Operateur;
use App\Entity\Intervention;
use App\Form\AffectFinalType;
use App\Repository\RapportRepository;
use App\Repository\OperateurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\InterventionRepository;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\VisiteTechniqueRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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
    public function addRapport(Int $id, Request $request, EntityManagerInterface $entityManager, ManagerRegistry $doctrine , OperateurRepository $operateurRepository, InterventionRepository $interventionRepository, VisiteTechniqueRepository $visiteTechniqueRepository): Response
    {
      $rapport = new Rapport();
      $entityManager = $doctrine->getManager();
      $intervention = $entityManager->getRepository(Intervention::class)->find($id);
      $form = $this->createForm(RapportType::class, $rapport);
      $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $rapport->setCreatedAt(new DateTimeImmutable());
            //$rapport->setUser($this->getUser());
            // je recupere l'utilisateur
            $userConnect = $this->getUser();
            // ensuite son id
            $userId = $userConnect->getId();
            // je m'en sers pour récupérer l'operateur lié
            $operateur = $operateurRepository->findUser($userId);
            // j'essaie de récupérer l'id à l'index 0
            $rapport->setOperateur($operateur[0]);

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
     * @Route("/cloture/{id}", name="cloture")
     */
    public function clotureRapport(Int $id, EntityManagerInterface $entityManager, Intervention $intervention, InterventionRepository $interventionRepository){
        
        $interventionInfo = $entityManager->getRepository(Intervention::class)->find($id);
        $interRapport = $interventionRepository->findRapByInt($id);

        if($interRapport == null){
            echo 'désolé il faut écrire un rapport pour cloturer';
            return $this->redirectToRoute('show_inter_ope');
        } else {
            $cloture = $interventionInfo;
            /* if () */
            $cloture->setCloture('1');
            $entityManager->persist($intervention);
            $entityManager->flush();
    
            return $this->redirectToRoute('show_inter_ope');
        }
    }


    /**
     * @Route("/completed/tasks", name="completed_tasks")
     */
    public function completedTasks(EntityManagerInterface $entityManager, InterventionRepository $interventionRepository, RapportRepository $rapportRepository)
    {
        $userSearch = $this->getUser();
        // je récupère l'id
        $userId = $userSearch->getId(); 
        // je récupère l'operateur avec le userId correspondant
        $userOp = $interventionRepository->findOp($userId);
        // $user = $this->getUser();
        $operateurId = $userOp[0]->getId();

        $intervention = $rapportRepository->findRapportbyId($operateurId);

            return $this->render('operateur/tasks.html.twig', [
                'intervention' => $intervention,
            ]);        
    }


    /**
     * @Route("/list/task/cloture/oui", name="list_task_cloture_oui", methods="GET")
     */
    public function listTaskClotureOui(EntityManagerInterface $entityManager, InterventionRepository $interventionRepository, OperateurRepository $OperateurRepository)
    {
        $userSearch = $this->getUser();
        // je récupère l'id
        $userId = $userSearch->getId(); 
        // je récupère l'operateur avec le userId correspondant
        $userOp = $interventionRepository->findOp($userId);
        // $user = $this->getUser();
        $operateurId = $userOp[0]->getId();

        $intervention = $OperateurRepository->findInterClotureOui($operateurId);

        return $this->render('operateur/tasks.html.twig', [
            'intervention' => $intervention,
        ]);
    }


    /**
     * @Route("/list/task/cloture/non", name="list_task_cloture_non", methods="GET")
     */
    public function listTaskClotureNon(EntityManagerInterface $entityManager, InterventionRepository $interventionRepository, OperateurRepository $OperateurRepository)
    {
        $userSearch = $this->getUser();
        // je récupère l'id
        $userId = $userSearch->getId(); 
        // je récupère l'operateur avec le userId correspondant
        $userOp = $interventionRepository->findOp($userId);
        // $user = $this->getUser();
        $operateurId = $userOp[0]->getId();

        $intervention = $OperateurRepository->findInterClotureNon($operateurId);

        return $this->render('operateur/tasks.html.twig', [
            'intervention' => $intervention,
        ]);
    }

    /**
     * @Route("/task/list/ot", name="task_list_ot", methods="GET")
     */
    public function taskListOt(Request $request, InterventionRepository $interventionRepository, OperateurRepository $OperateurRepository)
    {
        $userSearch = $this->getUser();
        // je récupère l'id
        $userId = $userSearch->getId(); 
        // je récupère l'operateur avec le userId correspondant
        $userOp = $interventionRepository->findOp($userId);
        // $user = $this->getUser();
        $operateurId = $userOp[0]->getId();

        $intervention = $OperateurRepository->findRapportByOt($operateurId, $request->query->get('search'));

        return $this->render('operateur/tasks.html.twig', [
            'intervention' => $intervention,
        ]);
    }
}
