<?php
    
namespace App\Controller;

use App\Entity\Intervention;
use Doctrine\ORM\Mapping\Id;
use Doctrine\DBAL\Schema\Index;
use App\Repository\OperateurRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\InterventionRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class CoreController extends AbstractController
{

    /**
     * premiere page avec bouton de connexion
     * @Route("/", name="first", methods="GET")
     * @return void
     */
    public function first(InterventionRepository $InterventionRepository)
    {
        $interventionId = $InterventionRepository->findAll();
        $user = $this->getUser();

        if ($user && $user->getRoles() == ('ROLE_OPERATEUR')) {
            
            $operateurInfo = $user->getId();
            $id = $InterventionRepository->findOp($operateurInfo);
            $idOp = $id[0]->getId();
            $operateurId = $InterventionRepository->findInterByIdForTheFirst($idOp);
           //dd($operateurId);

            return $this->render ('/accueil/first.html.twig', [
                'interventions' => $operateurId,
                'user' => $user,
            ]);
        
        } else {
            
            return $this->render ('/accueil/first.html.twig', [
                'interventions' => $interventionId,
                'user' => $user,
            ]);
        }
        
    }


    /**
     * affiche la page d'accueil
     * @Route("/start/home", name="show_inter_ope")
     * @return Response
     */
    public function showHome(InterventionRepository $InterventionRepository, ManagerRegistry $doctrine): Response
    {  
        //je recupere les informations de l'utilisateurs en suivant le modèle du dessus
        $userSearch = $this->getUser();
        // je récupère l'id
        $userId = $userSearch->getId(); 
        // je récupère l'operateur avec le userId correspondant
        $userOp = $InterventionRepository->findOp($userId);
                
        //dd($operateur);
        if ($userOp == null) {
            $admin = $InterventionRepository->findOp(4);
            $operateurId = $admin[0]->getId();
        } else {
            // $user = $this->getUser();
            $operateurId = $userOp[0]->getId();
        };
        
        // prepare data
        $entityManager = $doctrine->getManager();
        $operateur = $entityManager->getRepository(Intervention::class)->find($operateurId);
        
        $allIntOpe = $InterventionRepository->findInt($operateurId);

            return $this->render('accueil/home_html.twig', [
                'id' => $operateur,
                /* 'adresse' => $valeur, */
                'interventions' => $allIntOpe,
            ]);
    }


    /**
     * @Route("/start/choice", name="choice")
     */
    public function choice()
    {
        return $this->render('registration/choice.html.twig');
    }
    

    /**
     * @Route("/infos/{id}", name="inter_info")
     */
    public function interInfo(Int $id, InterventionRepository $interventionRepository) {

        $intervention = $interventionRepository->findInterInfoById($id);

            return $this->render('intervention/interInfo.html.twig', [
                'interventions' => $intervention,
            ]);
    }
} 