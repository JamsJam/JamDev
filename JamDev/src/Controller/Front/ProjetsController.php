<?php

namespace App\Controller\Front;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProjetsController extends AbstractController
{
    #[Route('/projets', name: 'app_front_projets')]
    public function index(): Response
    {
        return $this->render('front/projets/index.html.twig', [
            'controller_name' => 'ProjetsController',
        ]);
    }
}
