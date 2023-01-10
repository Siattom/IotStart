<?php

namespace App\Controller;

use App\Repository\RapportRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class FiltreController extends AbstractController
{
    /**
     * @Route("/listeRapport/filtre/tel", name="listeRapport_filtre_tel", methods="GET")
     */
    public function listeRapportFiltreTel(RapportRepository $RapportRepository, Request $request)
    {
        $rapports = $RapportRepository->findRapportByTel($request->query->get('search'));
        $visite = $RapportRepository->findVsiteTechniqueByTel($request->query->get('search'));
        //dd($rapport, $visite);

        return $this->render('/rapport/listadmin.html.twig', [
            'rapports' => $rapports,
            'visite' => $visite,
        ]);
    }


    /**
     * @Route("/list/rapport/cloture/{cloturevalue}", name="list_rapport_cloture", methods="GET")
     */
    public function listeRapportFiltreCloture(Int $cloturevalue, RapportRepository $RapportRepository)
    {
        $rapports = $RapportRepository->findRapportByCloture($cloturevalue);
        $visite = $RapportRepository->findVisiteByCloture($cloturevalue);
        //dd($rapports, $visite)

        return $this->render('/rapport/listadmin.html.twig', [
            'rapports' => $rapports,
            'visite' => $visite,
        ]);
    }


}