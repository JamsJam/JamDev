<?php

namespace App\Controller\Admin;

use App\Entity\Projets;
use App\Form\ProjetsType;
use App\Repository\ProjetsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/projets')]
class ProjetsController extends AbstractController
{
    #[Route('/', name: 'app_admin_projets_index', methods: ['GET'])]
    public function index(ProjetsRepository $projetsRepository): Response
    {
        return $this->render('admin/projets/index.html.twig', [
            'projets' => $projetsRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_admin_projets_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ProjetsRepository $projetsRepository): Response
    {
        $projet = new Projets();
        $form = $this->createForm(ProjetsType::class, $projet);
        $form->handleRequest($request);
        $dossier = [1 => "siteComplet", 2 => "interface" ,3 =>"POC", 4 => "autres" ];

        if ($form->isSubmitted() && $form->isValid()) {
            $categorieId = $form->get("categorie")->getData()->getId();
            $nomImages = [];

            //*     =====================================
            //*     =====================================
            //todo      Enregistrement des images en bdd
            //*     =====================================
            //*     =====================================
            
            for ($i=0; $i < 3; $i++) { 

                $file = $form->get('image'.$i+1)->getData();
                
                //? 1) renommer les images
                $fileNewName = date("YmdHis").'-'.Uniqid().'-'.rand(100,999).'-'.$file->getClientOriginalName();
                
                //? 2) determiner un dossier pour chaque categorie
                //? 3) copier les images dans le dossier
                $file->move(
                    $this->getParameter($dossier[$categorieId]),
                    $fileNewName
                );
                //? 4) recuperer les noms des images,  
                array_push($nomImages, $fileNewName);

            }
            //? 5)  setImages 
            $projet->setImages(implode("--", $nomImages));
            // dd($projet);

            
            //*     =================================
            //!     =================================
            //*     =================================
            
            
            




            $projetsRepository->save($projet, true);

            return $this->redirectToRoute('app_admin_projets_index', [], Response::HTTP_SEE_OTHER);
        }

        //todo integrer formulaire a la page a la place de l'import
        return $this->render('admin/projets/new.html.twig', [
            'projet' => $projet,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_projets_show', methods: ['GET'])]
    public function show(Projets $projet): Response
    {
        return $this->render('admin/projets/show.html.twig', [
            'projet' => $projet,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_projets_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Projets $projet, ProjetsRepository $projetsRepository): Response
    {
        $form = $this->createForm(ProjetsType::class, $projet);
        $form->handleRequest($request);
        // dd($projet);
        
        $projet->getImages();
        // explode("--",$projet->getImages());
        $oldImgNames = explode("--",$projet->getImages());
        $ImgNames = explode("--",$projet->getImages());
        $dossier = [1 => "siteComplet", 2 => "interface" ,3 =>"POC", 4 => "autres" ];
        $oldCategorieId = $projet->getCategorie()->getId();
        $image1 = $this->getParameter($dossier[$oldCategorieId])."\\".$ImgNames[0]; 
        $image2 = $this->getParameter($dossier[$oldCategorieId])."\\".$ImgNames[1]; 
        $image3 = $this->getParameter($dossier[$oldCategorieId])."\\".$ImgNames[2]; 
        // dd($oldImgNames, $image1, $image2, $image3  );
        
        $currentimages = [1=>$image1, 2=>$image2, 3=>$image3] ;
        





        if ($form->isSubmitted() && $form->isValid()) {
            
            $categorieId = $projet->getCategorie()->getId();

            for ($i=0; $i < 3; $i++) { 
                if ($form->get('image'.$i+1)->getData()) {

                    
                    unlink($currentimages[$i+1]);

                    $file = $form->get('image'.$i+1)->getData();
                
                    //? 1) renommer les images
                    $fileNewName = date("YmdHis").'-'.Uniqid().'-'.rand(100,999).'-'.$file->getClientOriginalName();
                    
                    //? 2) determiner un dossier pour chaque categorie
                    //? 3) copier les images dans le dossier
                    $file->move(
                        $this->getParameter($dossier[$categorieId]),
                        $fileNewName
                    );
                    $ImgNames[$i+1] = $fileNewName;

                    
                }
            }
            
            // dd("--",implode($oldImgNames),implode("--", $ImgNames));
            $projetsRepository->save($projet, true);

            return $this->redirectToRoute('app_admin_projets_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/projets/edit.html.twig', [
            'projet' => $projet,
            'form' => $form,
            'img' => $oldImgNames


        ]);
    }

    #[Route('/{id}', name: 'app_admin_projets_delete', methods: ['POST'])]
    public function delete(Request $request, Projets $projet, ProjetsRepository $projetsRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$projet->getId(), $request->request->get('_token'))) {
            $projetsRepository->remove($projet, true);
        }

        return $this->redirectToRoute('app_admin_projets_index', [], Response::HTTP_SEE_OTHER);
    }
}
