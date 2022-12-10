<?php

namespace App\Controller\Front;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ServiceController extends AbstractController
{
    #[Route('/service', name: 'app_front_service')]
    public function index(): Response
    {
        return $this->render('front/service/index.html.twig', [
            'controller_name' => 'ServiceController',
        ]);
    }
}
