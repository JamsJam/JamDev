<?php

namespace App\Controller\Front;

use App\Entity\Projets;

use App\Entity\Categorie;
use App\Repository\ProjetsRepository;
use App\Repository\CategorieRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProjetsController extends AbstractController
{
    #[Route('/projets/', name: 'app_front_projets')]
    public function index(CategorieRepository $cr, array $categorieId = []): Response
    {
        $categories = $cr->findall();
        foreach ($categories as  $categorie) {
            
            array_push($categorieId,$categorie->getid());
        }
        
        return $this->render('front/projets/index.html.twig', [
            "projetCategorieId" => $categorieId
        ]);
    }
    


    #[Route('/projets/catalogue/', name: 'app_front_catalogue',methods: ['GET'])]
    public function catalogue(Request $request, ProjetsRepository $pr, CategorieRepository $cr): Response
    {
        $categorie = $request->query->get("categorie");
        
        $projets = $pr->findBy(["categorie" => $categorie]);
        

        $dossier = [1 => "siteComplet", 2 => "interface" ,3 =>"POC", 4 => "autres" ];
        $nomCategorie =  $cr->findOneBy(["id"=>$categorie]);

        return $this->render('front\projets\catalogue.html.twig', [
            "projets" => $projets,
            "categorie" => $nomCategorie,
            "dossier"   => $dossier
        ]);
    }




    #[Route('/projets/{id}', name: 'app_front_projets_show', methods: ['GET'])]
    public function show(Projets $projet): Response
    { 
        
        $imgs = explode('--',$projet->getImages());
        $dossier = [1 => "siteComplet", 2 => "interface" ,3 =>"POC", 4 => "autres" ];

        // dd($imgPaths[0]);
        return $this->render('front/projets/show.html.twig', [
            'projet' => $projet,
            'dossier' => $dossier,
            'imgs'   => $imgs
        ]);
    }




    // ******************************************************** Route pour variable en json

    /**
     * @
     */
    #[Route('/api/projet', name: 'app_searchJson_projet', methods: ['POST', 'GET'])]
    public function SearchJson(SerializerInterface $serializer, ProjetsRepository $projetsRepository,Request $request): JsonResponse
    {

        $categorieId = $request->request->get('categorie');
        $value = $request->request->get('valeur');
        $result = $projetsRepository-> SearchId($categorieId,$value);

        $jsonContent = json_encode($result);
        

        return new JsonResponse($jsonContent, JsonResponse::HTTP_OK, [], true) ;        
    }

}
