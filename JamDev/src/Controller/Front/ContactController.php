<?php

namespace App\Controller\Front;

use App\Entity\Mail;
use App\Form\MailType;
use App\Message\MailNotification;
use App\Repository\MailRepository;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_front_contact')]
    public function index(Request $request, MailRepository $mailRepository,  MessageBusInterface $bus): Response
    {
        $mail = new Mail;
        $mail->setSendAt(new \DateTimeImmutable('now',new \DateTimeZone('GMT-04:00')));
        // dd($mail);
        
        //? creation du formulaire
        
        $form = $this->createForm(MailType::class, $mail);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')   
                $url = "https://";   
            else  
                $url = "http://";   
            // Append the host(domain name, ip) to the URL.   
            $url.= $_SERVER['HTTP_HOST'];   
            
            // Append the requested resource location to the URL   
            $url.= $_SERVER['REQUEST_URI'];    

            $mail = $form->getData();
                //? =================================================
                //*         *********** EMAIL ************
                //? =================================================
                    $content = $mail->getMessage();
                    $email = new MailNotification(
                    //todo    1) Sujet
                                "Prise de contact",
                    //todo    2) destinataire
                                "j.antoine971@hotmal.fr",
                    //todo    3) expeditaire
                                "contact@jamdev.fr",
                    //todo    4) template
                                "front/contact/contact_email.html.twig",
                    //todo    5) parametres
                                [
                                    'content' => $content,
                                    'mail'=> $mail,
                                    'url' => $url
                                ]
                        );
                    $bus->dispatch($email);
            //? =================================================
            //*         *********** FIN EMAIL ************
            //? =================================================

            $mailRepository->save($mail, true);

            //?appFlash 
            $this->addFlash('mailConfirm', 'Votre email a bien été envoyé. Vous serez contacter d\'ici 48 heures ');


            //?redirection vers accueil
            return $this->redirectToRoute('app_front_accueil', [
                
            ]);
        }

    


        return $this->render('front/contact/index.html.twig', [
            'form' => $form,
        ]);
    }
}
