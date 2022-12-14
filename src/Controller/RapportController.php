<?php

namespace App\Controller;

use App\Entity\Rapport;
use DateTimeImmutable;
use App\Form\RapportType;
use App\Repository\RapportRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\InterventionRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class RapportController extends AbstractController
{

    /**
     * display list rapports
     * @Route("/inter/rapport/list", name="rapport_list_admin", methods="GET")
     * @return void
     */

    public function rapportList(RapportRepository $rapportRepository, InterventionRepository $interventionRepository)
    {
        // il faut appeler la fonction qui récupère les rapports
        $rapports = $rapportRepository->findRapport();
        $visite = $rapportRepository->findVisite(); 

        return $this->render('/rapport/listadmin.html.twig', [
                'rapports' => $rapports,
                'visite' => $visite,
            ]); 
    }


    /**
     * @Route("/inter/rapport/list/asc", name="rapport_list_asc", methods="GET")
     */
    public function rapportListAsc(RapportRepository $rapportRepository, InterventionRepository $interventionRepository)
    {
        // il faut appeler la fonction qui récupère les rapports
        $rapports = $rapportRepository->findRapportAsc();
        $visite = $rapportRepository->findVisiteAsc(); 

        return $this->render('/rapport/listadmin.html.twig', [
                'rapports' => $rapports,
                'visite' => $visite,
            ]); 
    }


    /**
    * @Route("/rapport/edit/{id}", name="rapport_edit", methods={"GET", "POST"})
    */
    public function edit(Int $id, Request $request, Rapport $rapport, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(RapportType::class, $rapport);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $rapport->setUpdatedat(new DateTimeImmutable());

            $entityManager->persist($rapport);
            $entityManager->flush();

            if ($this->getUser()->getRoles() == ["ROLE_OPERATEUR"]){
                return $this->redirectToRoute('completed_tasks');
            } else {
                return $this->redirectToRoute('rapport_list_admin');
            }
            
        }

            return $this->render('rapport/rapportAdd.html.twig', [
                'rapportForm' =>$form->createView(),
            ]);
    }
}