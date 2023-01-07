<?php

namespace App\Controller\Admin;

use App\Entity\Projets;
use App\Form\ProjetsType;
use App\Repository\ProjetsRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\RadioType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin/projets')]
class ProjetsController extends AbstractController
{
    #[Route('/', name: 'app_admin_projets_index', methods: ['GET', 'POST'])]
    public function index(ProjetsRepository $projetsRepository, Request $request): Response
    {

        $dossier = [1 => "siteComplet", 2 => "interface" ,3 =>"POC", 4 => "autres" ];
        $search = $this->createFormBuilder(null)
            ->add('recherche',TextType::class,[
                "required" => false,
                "label" => false,
                "attr" => [
                    "class" => "input__text input--empty",
                    "placeholder" => "Recherche..."
                ]
            ])
            ->add('filtre', ChoiceType::class,[
                "expanded" => true,
                "multiple" => false,
                "label" => false,
                'choices' => [
                    'Technologie' => "techno",
                    'Titre' => "titre"
                ]
            ])
            ->add("Submit", SubmitType::class, [
                'label' => 'Rechercher',
                'attr' => [
                    'class' => "bouton bouton--secondary"
                ]
            ])
            ->getForm();
        $search->handleRequest($request);


        if ($search->isSubmitted() && $search->isValid() && !$search->get('recherche')->getData() == null) {
            $projets = [];
            $filtre = $search->get('filtre')->getData();
            $recherche = $search->get('recherche')->getData();
            
            if ($filtre == 'titre') {
                
                $resultats = $projetsRepository->chercheTitre($recherche);
            }
            else{
                
                $resultats = $projetsRepository->chercheTechno($recherche);
            }
            
            foreach ($resultats as $resultat) {
                $projet = $projetsRepository->findOneBy(["id" => $resultat["id"]]);
                array_push($projets, $projet);
            }
            
            
            return $this->render('admin/projets/index.html.twig', [
                'projets' => $projets,
                'dossier' => $dossier,
                'search'  => $search
            ]);
        }
        
        
        

        return $this->render('admin/projets/index.html.twig', [
            'projets' => $projetsRepository->findby([],['id' => 'desc']),
            'dossier' => $dossier,
            'search'  => $search
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
        $imgs = explode('--',$projet->getImages());
        $dossier = [1 => "siteComplet", 2 => "interface" ,3 =>"POC", 4 => "autres" ];
        
        $image1 = $this->getParameter($dossier[$projet->getCategorie()->getId()])."\\".$imgs[0]; 
        $image2 = $this->getParameter($dossier[$projet->getCategorie()->getId()])."\\".$imgs[1]; 
        $image3 = $this->getParameter($dossier[$projet->getCategorie()->getId()])."\\".$imgs[2]; 
        
        $imgPaths = [$image1,$image2,$image3 ] ;

        return $this->render('admin/projets/show.html.twig', [
            'projet'  =>  $projet,
            'imgs'    =>  $imgPaths
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
        $cateProjet = $dossier[$oldCategorieId];
        // dd($projet);





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

            $projet->setImages(implode('--',$ImgNames));
            
            
            $projetsRepository->save($projet, true);

            return $this->redirectToRoute('app_admin_projets_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/projets/edit.html.twig', [
            'projet'    => $projet,
            'form'      => $form,
            'img'       => $oldImgNames,
            'oldImg'    => $ImgNames,
            'cateProjet' => $cateProjet
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
