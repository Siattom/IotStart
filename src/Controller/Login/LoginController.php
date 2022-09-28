<?php

namespace App\Controller\Login;

use App\Repository\InterventionRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class LoginController extends AbstractController
{
    /**
     * Display login form and process login form (GET + POST)
     * 
     * @Route("/login", name="app_login")
     */
    public function index(AuthenticationUtils $authenticationUtils): Response
    {
         // get the login error if there is one
         $error = $authenticationUtils->getLastAuthenticationError();

         // last username entered by the user
         $lastUsername = $authenticationUtils->getLastUsername();

       return $this->render('login/index.html.twig', [
             'controller_name' => 'LoginController',
             'last_username' => $lastUsername,
             'error'         => $error,
        ]);
    }

    /**
     * Logout
     * 
     * @Route("/logout", name="app_logout")
     */
    public function logout(InterventionRepository $InterventionRepository)
    {
        // Ce code ne sera jamais exécuté
        // le composant de sécurité va intercepter la requête avant.
        $interventionId = $InterventionRepository->findAll();

        return $this->redirectToRoute('app_register');

        return $this->render ('/accueil/first.html.twig', [
            'interventions' => $interventionId,
        ]);
    }
}