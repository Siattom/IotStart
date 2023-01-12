<?php

namespace App\Controller\Login;

use App\Entity\User;
use App\Entity\Client;
use App\Form\UserType;
use DateTimeImmutable;
use App\Form\PosteType;
use App\Form\UserEditType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\InterventionRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasher;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

/**
 * On peut préfixer toutes les routes de ce contrôleur
 * 
 * @Route("/user")
 */
class UserController extends AbstractController
{
     public function index(UserRepository $userRepository): Response
    {
        return $this->render('index.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }


    /**
     * @Route("/new", name="back_user_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $userPasswordHasher, InterventionRepository $InterventionRepository): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // set the createdAt
            $user->setCreatedAt(new DateTimeImmutable());
            $user->setRoles("ROLE_ADMIN");
            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash('success', 'Utilisateur ajouté(e).');

            return $this->render('/accueil/first.html.twig', [
                'interventions' => $InterventionRepository->findAll(),
            ]);
        }

        return $this->renderForm('accueil/new.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }


    /**
	 * return the id of the user
	 * 
	 * @Route("/login", name="login", methods={"POST"})
	 */
	public function login( ManagerRegistry $doctrine, Request $request): Response
	{	

		
		$userAsJson = $request->getContent();
		
		// request to object
		$userDecode = json_decode($userAsJson);

		// get the email 
		$email = $userDecode->email;

		// get user objects
		$entityManager = $doctrine->getManager();
		$user = $entityManager->getRepository(User::class)->findBy(["email" => $email]);
		
		$userId = $user[0]->getId();
			
		$data = [
			'id' => $userId,
	   ];

		    // return id and code 200
		    return $this->render('/accueil/home_html.twig');
            return $this->json($data, Response::HTTP_OK);
	}

    
    /**
     * @Route("/{id}/edit", name="back_user_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, User $user, EntityManagerInterface $entityManager, UserPasswordHasherInterface $userPasswordHasher): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // Gestion du mot de passe modifié ou non ?
            // On va le chercher directement dans le formulaire car non mappé sur l'entité
            if ($form->get('password')->getData()) {
                // Si oui, on hache le nouveau mot de passe
                $hashedPassword = $userPasswordHasher->hashPassword($user, $form->get('password')->getData());
                // On écrase le mot de passe en clair par le mot de passe haché
                $user->setPassword($hashedPassword);
            }

            $entityManager->flush();

            $this->addFlash('success', 'Utilisateur modifié(e).');

            return $this->redirectToRoute('back_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('/accueil/first.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }


    /**
     * @Route("/{id}", name="back_user_delete", methods={"POST"})
     */
    public function delete(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $entityManager->remove($user);
            $entityManager->flush();
        }

        $this->addFlash('success', $user->getEmail() . ', supprimé.');

        return $this->redirectToRoute('/accueil/first.html.twig', [], Response::HTTP_SEE_OTHER);
    }
}
