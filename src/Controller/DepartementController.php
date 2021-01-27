<?php

namespace App\Controller;

use App\Service\CallApiService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DepartementController extends AbstractController
{
        /**
     * @Route("/departement", name="departement")
     */
    public function departement(CallApiService $callApiService): Response
    {
        /* dd($callApiService->getFranceData()); */
        return $this->render('departement/index.html.twig', [
            'data' => $callApiService->getFranceData(),
            'departments' => $callApiService->getAllData(),
        ]);
    }
}
