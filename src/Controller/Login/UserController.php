<?php

namespace App\Controller\Login;


use App\Entity\User;
use App\Form\UserEditType;
use App\Form\UserType;
use App\Repository\InterventionRepository;
use App\Repository\UserRepository;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasher;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * On peut préfixer toutes les routes de ce contrôleur
 * 
 * @Route("/user")
 */
class UserController extends AbstractController
{
    /**
     * @Route("/", name="back_user_index", methods={"GET"})
     */
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
        // Pour hacher le mot de passe :
        // - on a récupéré le service adéquat (injection dans la méthode du contrôleur)
        // - on lui donne sur la méthode hashPassword, notre $user
        // - et le mot de passe en clair (qui est déjà dnas le user !)
        //$hashedPassword = $userPasswordHasher->hashPassword($user, $user->getPassword());
        //dd($hashedPassword);
        // On écrase le mot de passe en clair par le mot de passe haché
        //$user->setPassword($hashedPassword);

        // set the createdAt
        $user->setCreatedAt(new DateTimeImmutable());
        $user->setRole("ROLE_ADMIN");
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
    

//    	/**
//	 * Create an user
//	 * @Route("/new", name="create", methods={"POST", "GET"})
//	 * @return Response
//	 */
//	public function create(ManagerRegistry $doctrine, User $user, UserPasswordHasherInterface $hasher, Request $request, UserRepository $userRepository, SerializerInterface $serializer): Response
//	{
//        $form = $this->createForm(UserType::class, $user);
//        $form->handleRequest($request);
//		$userAsJson = $request->getContent();
//        
//		/** @var User $user */
//		// deserialize user
//		$userAsJson = new User;
//		
//		// email 
//	   	$email = $userAsJson->getEmail();
//		$filteredEmail = filter_var($email, FILTER_VALIDATE_EMAIL);
//		$userAsJson->setEmail($filteredEmail);
//		
//		// password verification 
//		$password = $userAsJson->getPassword();
//		$filteredPassword = filter_var($password, FILTER_SANITIZE_SPECIAL_CHARS);
//
//		// set the createdAt
//		$userAsJson->setCreatedAt(new DateTimeImmutable());
//		
//		// Hash password
//		$hashedPassword = $hasher->hashPassword($userAsJson, $filteredPassword);
//		$userAsJson->setPassword($hashedPassword);
//		
//		// set role userAs$userAsJson 
//		$userAsJson->setRole("ROLE_USER");
//		// save user in database
//		$entityManager = $doctrine->getManager();
//
//		$entityManager->persist($user);
//
//		$entityManager->flush();
//
//		$data = [
//			 'id' => $userAsJson->getId(),
//		];
//
//		// return id and code 201
//		return $this->json($data, Response::HTTP_CREATED);
//	}

//
//    /**
//     * @Route("/{id}", name="back_user_show", methods={"GET"})
//     * 
//     * $user = null permet de récupérer la main sur la 404
//     */
//    public function show(User $user = null): Response
//    {
//        if ($user === null) {
//            throw $this->createNotFoundException('Utilisateur non trouvé(e).');
//        }
//
//        return $this->render('/accueil/news.html.twig', [
//            'user' => $user,
//        ]);
//    }

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
