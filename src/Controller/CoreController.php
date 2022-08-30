<?php
    
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CoreController extends AbstractController
{
    /**
     * show page test
     * @Route("/show", name="show", methods="GET")
     * @return Response
     */
    public function showHome()
    {
        // get the first page of application
        $content=$this->show('home', [

        ]);
        return new Response;
    }

    public function show()
    {
        

        // Debut de la View
        require_once __DIR__ . '/../views/home.tpl.php';
    }
}