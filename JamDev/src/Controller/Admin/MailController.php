<?php

namespace App\Controller\Admin;

use App\Entity\Mail;
use App\Form\MailType;
use App\Repository\MailRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/mail')]
class MailController extends AbstractController
{
    #[Route('/', name: 'app_admin_mail_index', methods: ['GET'])]
    public function index(MailRepository $mailRepository): Response
    {
        return $this->render('admin/mail/index.html.twig', [
            'mails' => $mailRepository->findBy([],["id"=>"DESC"]),
        ]);
    }

    //! Creation de mail UNIQUEMENT via formulaire de contact
    // #[Route('/new', name: 'app_admin_mail_new', methods: ['GET', 'POST'])]
    // public function new(Request $request, MailRepository $mailRepository): Response
    // {
    //     $mail = new Mail();
    //     $form = $this->createForm(MailType::class, $mail);
    //     $form->handleRequest($request);

    //     if ($form->isSubmitted() && $form->isValid()) {
    //         $mailRepository->save($mail, true);

    //         return $this->redirectToRoute('app_admin_mail_index', [], Response::HTTP_SEE_OTHER);
    //     }

    //     return $this->render('admin/mail/new.html.twig', [
    //         'mail' => $mail,
    //         'form' => $form,
    //     ]);
    // }

    #[Route('/{id}', name: 'app_admin_mail_show', methods: ['GET'])]
    public function show(Mail $mail, MailRepository $mailRepository): Response
    {
        if (! $mail->isVu()) {
            $mail->setVu(1);
            $mailRepository->save($mail,true);
        }
        return $this->render('admin/mail/show.html.twig', [
            'mail' => $mail,
        ]);
    }

    //! Pas de modification de mail car simple sauvegarde
    // #[Route('/{id}/edit', name: 'app_admin_mail_edit', methods: ['GET', 'POST'])]
    // public function edit(Request $request, Mail $mail, MailRepository $mailRepository): Response
    // {
    //     $form = $this->createForm(MailType::class, $mail);
    //     $form->handleRequest($request);

    //     if ($form->isSubmitted() && $form->isValid()) {
    //         $mailRepository->save($mail, true);

    //         return $this->redirectToRoute('app_admin_mail_index', [], Response::HTTP_SEE_OTHER);
    //     }

    //     return $this->renderForm('admin/mail/edit.html.twig', [
    //         'mail' => $mail,
    //         'form' => $form,
    //     ]);
    // }

    #[Route('/{id}', name: 'app_admin_mail_delete', methods: ['POST'])]
    public function delete(Request $request, Mail $mail, MailRepository $mailRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$mail->getId(), $request->request->get('_token'))) {
            $mailRepository->remove($mail, true);
        }

        return $this->redirectToRoute('app_admin_mail_index', [], Response::HTTP_SEE_OTHER);
    }
}
