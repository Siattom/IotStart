<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\Securite;
use App\Form\SecuriteType;
use App\Repository\ClientRepository;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;


class clientController extends AbstractController
{
    /**
     * @Route("/client/securite/add" , name="securite_add")
     */
    public function addSecurite(Request $request, EntityManagerInterface $entityManager, ClientRepository $clientRepository): Response
    {
        $securite = new Securite;
        $form = $this->createForm(SecuriteType::class, $securite);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $securite->setCreatedAt(new DateTimeImmutable());
            $securite->setUser($this->getUser());

            $userConnect = $this->getUser();
            // ensuite son id
            $userId = $userConnect->getId();
            // je m'en sers pour récupérer l'operateur lié
            $client = $clientRepository->findUser($userId);
            //dd($client);
            $securite->setClient($client[0]);
            //dd($operateurId); 
           
            $entityManager->persist($securite);
            $entityManager->flush();

            
            return $this->redirectToRoute('first');
        }

        return $this->render('client/post.html.twig', [
            'postFormSecurite' => $form->createView(),
        ]);
    }


    /**
     * @Route("/my/securite/list", name="my_securite_list")
     */
    public function mySecuriteList(ClientRepository $clientRepository)
    {
        $userConnect = $this->getUser();
        $userId = $userConnect->getId();

        $securite = $clientRepository->findSecuriteById($userId);

        return $this->render('client/my_securite_list.html.twig', [
            'securite' => $securite,
        ]);
    }


    /**
     * @Route("/client/edit/securite/{id}", name="edit_securite")
     */
    public function editSecurite(Securite $securite, Request $request, EntityManagerInterface $entityManager)
    {
        $form = $this->createForm(SecuriteType::class, $securite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($securite);
            $entityManager->flush();

            return $this->redirectToRoute('my_securite_list');
        }

        return $this->render('client/post.html.twig', [
            'postFormSecurite' => $form->createView(),
        ]);
    }

    
    /**
     * @Route("/list/clients", name="list_clients")
     */
    public function listClients(ClientRepository $clientRepository)
    {
        $client = $clientRepository->findAll();
        
        return $this->render('client/list.html.twig', [
            'client' => $client,
        ]);
    }
}