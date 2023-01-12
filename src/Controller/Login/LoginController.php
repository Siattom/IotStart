<?php

namespace App\Controller\Login;

use App\Entity\User;
use App\Form\LoginType;
use App\Repository\InterventionRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

/**
 * @Route("/start")
 */
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
         
         $form = $this->createForm(LoginType::class, [
            'login[_username]' => $lastUsername,
        ]);

       return $this->render('login/index.html.twig', array(
        'form' => $form->createView(),
        'error'         => $error
       ));
    }


    /**
     * 
     * @Route("/firstlogin", name="app_firstlogin")
     */
    public function firstindex(AuthenticationUtils $authenticationUtils): Response
    {
         // get the login error if there is one
         $error = $authenticationUtils->getLastAuthenticationError();

         // last username entered by the user
         $lastUsername = $authenticationUtils->getLastUsername();
         
         $form = $this->createForm(LoginType::class, [
            'login[_username]' => $lastUsername,
        ]);

        
        return $this->render('login/indexfirst.html.twig', array(
            'form' => $form->createView(),
            'error'         => $error
        ));
        return $this->redirectToRoute('choice');
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

        return $this->redirectToRoute('first');

        return $this->render ('/accueil/first.html.twig', [
            'interventions' => $interventionId,
        ]);
    }
}