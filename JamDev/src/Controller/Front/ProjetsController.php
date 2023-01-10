<?php

namespace App\Controller\Front;

use App\Entity\Categorie;
use App\Repository\ProjetsRepository;
use App\Repository\CategorieRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProjetsController extends AbstractController
{
    #[Route('/projets/', name: 'app_front_projets')]
    public function index(CategorieRepository $cr, array $categorieId = []): Response
    {
        $categories = $cr->findall();
        foreach ($categories as  $categorie) {
            // dd($categorie);
            array_push($categorieId,$categorie->getid());
        }
        // dd($categories);
        return $this->render('front/projets/index.html.twig', [
            "projetCategorieId" => $categorieId
        ]);
    }
    
    #[Route('/projets/catalogue/', name: 'app_front_catalogue',methods: ['GET'])]
    public function catalogue(Request $request, ProjetsRepository $pr): Response
    {
        $categorie = $request->query->get("categorie");
        $projets = $pr->findBy(["categorie" => $categorie]);
        dd($projets);
        return $this->render('front\projets\catalogue.html.twig', [
            "projets" => $projets,
        ]);
    }

    #[Route('/projets/{id}/', name: 'app_front_projets_show')]
    public function show(): Response
    {
        return $this->render('front/projets/index.html.twig', [
            'controller_name' => 'ProjetsController',
        ]);
    }


}
