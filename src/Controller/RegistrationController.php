<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\Operateur;
use App\Entity\User;
use App\Form\PosteType;
use App\Form\PosteOperateurType;
use App\Form\RegistrationFormType;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Id;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/start")
 */
class RegistrationController extends AbstractController
{
    /**
     * @Route("/register", name="app_register")
     */
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setCreatedAt(new DateTimeImmutable());
            $user->setPassword(
            $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $entityManager->persist($user);
            $entityManager->flush();
            // do anything else you need here, like send an email
            
            return $this->redirectToRoute('app_firstlogin');// ici je redirige vers firstlogin, si ça ne fonctionne pas remettre login
        }

            return $this->render('registration/register.html.twig', [
                'registrationForm' => $form->createView(),
            ]);
    }


    /**
     * @Route("/addclient", name="add_client")
     */
    public function addClient(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response
    {
        $client = new Client();
        $form = $this->createForm(PosteType::class, $client);
        $form->handleRequest($request);

        $user = $this->getUser();
        $name = $user->getName();
        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $client->setCreatedAt(new DateTimeImmutable());
            $client->setND('00000000000');
            $client->setUser($this->getUser());
            $client->setName($name);

            $entityManager->persist($client);
            $entityManager->flush();

            return $this->redirectToRoute('first');
        }

            return $this->render('registration/post.html.twig', [
                'postForm' => $form->createView(),
            ]);
    }


    /**
     * @Route("/addoperateur", name="add_operateur")
     */
    public function addOperateur(Request $request, EntityManagerInterface $entityManager): Response
    {
        $operateur = new Operateur();
        $form = $this->createForm(PosteOperateurType::class, $operateur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $operateur->setCreatedAt(new DateTimeImmutable());
            // on associe l'operateur à l'user 
            $operateur->setUser($this->getUser());

            $entityManager->persist($operateur);
            $entityManager->flush();
        
            return $this->redirectToRoute('first');
            //return $this->render('registration/choice.html.twig');
        }

            return $this->render('registration/addOpe.html.twig', [
                'postForm' => $form->createView(),
            ]);
    }
}
