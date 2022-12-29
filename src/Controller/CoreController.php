<?php
    
namespace App\Controller;

use App\Entity\Intervention;
use App\Repository\InterventionRepository;
use Doctrine\DBAL\Schema\Index;
use Doctrine\ORM\Mapping\Id;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


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
        
        return $this->render ('/accueil/first.html.twig', [
            'interventions' => $interventionId,
            'user' => $user,
        ]);
    }

    /**
     * affiche la page d'accueil
     * @Route("/start/home", name="show_inter_ope")
     * @return Response
     */
    public function showHome(InterventionRepository $InterventionRepository, ManagerRegistry $doctrine): Response
    {
        
        //--------------------------------------------------------------
        // phase de test pour supprimer l'id en url
        //--------------------------------------------------------------
                
        //je recupere les informations de l'utilisateurs en suivant le modèle du dessus
        $userSearch = $this->getUser();
        // je récupère l'id
        $userId = $userSearch->getId(); 
        // je récupère l'operateur avec le userId correspondant
        $userOp = $InterventionRepository->findOp($userId);
        // $user = $this->getUser();
        $operateurId = $userOp[0]->getId();
        //--------------------------------------------------------------
        // fin de test
        //--------------------------------------------------------------

        // prepare data
        $entityManager = $doctrine->getManager();
        $operateur = $entityManager->getRepository(Intervention::class)->find($operateurId);
        
        $allIntOpe = $InterventionRepository->findInt($operateurId);
/*         $valeur =  $intervention->getAdresse(); */

        // on rend le template associé en lui donnant l'operateur id

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
    
} 