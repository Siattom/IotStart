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

/**
 * @Route("/client")
 */
class clientController extends AbstractController
{
    /**
     * @Route("/securite/add" , name="securite_add")
     */
    public function addSecurite(Request $request, EntityManagerInterface $entityManager, ClientRepository $clientRepository): Response
    {
        $securite = new Securite;
        $form = $this->createForm(SecuriteType::class, $securite);
        $form->handleRequest($request);
        //$clientId = $clientRepository->findClient($clientid);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $securite->setCreatedAt(new DateTimeImmutable());
            $securite->setUser($this->getUser());
           // $securite->setClient($this->getUser());
           
            $entityManager->persist($securite);
            $entityManager->flush();

            return $this->redirectToRoute('first');
        }

        return $this->render('client/post.html.twig', [
            'postFormSecurite' => $form->createView(),
        ]);
    }
}