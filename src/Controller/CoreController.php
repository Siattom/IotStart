<?php
    
namespace App\Controller;

use App\Entity\Intervention;
use App\Repository\InterventionRepository;
use Doctrine\DBAL\Schema\Index;
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
        
        return $this->render ('/accueil/first.html.twig', [
            'interventions' => $interventionId,
        ]);
    }

    /**
     * show page test
     * @Route("/home/{id}", name="show_inter_ope",requirements={"id"="\d+"})
     * @return Response
     */
    public function showHome(Int $id, InterventionRepository $InterventionRepository, ManagerRegistry $doctrine): Response
    {

        // prepare data
        $entityManager = $doctrine->getManager();
        $operateur = $entityManager->getRepository(Intervention::class)->find($id);
        $allIntOpe = $InterventionRepository->findInt($id);
        //dd($allIntOpe);
/*         $valeur =  $intervention->getAdresse(); */

        // on rend le template associé en lui donnant l'operateur id

        return $this->render('accueil/home_html.twig', [
            'id' => $operateur,
            /* 'adresse' => $valeur, */
            'interventions' => $allIntOpe,
        ]);
    }

    
} 