<?php

namespace App\Controller\Admin;

use App\Entity\Projets;
use App\Form\Projets1Type;
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

        if ($form->isSubmitted() && $form->isValid()) {
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

        if ($form->isSubmitted() && $form->isValid()) {
            $projetsRepository->save($projet, true);

            return $this->redirectToRoute('app_admin_projets_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/projets/edit.html.twig', [
            'projet' => $projet,
            'form' => $form,
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
