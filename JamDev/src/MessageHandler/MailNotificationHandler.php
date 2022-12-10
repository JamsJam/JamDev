<?php

namespace App\MessageHandler;

use App\Message\MailNotification;
use Symfony\Component\Mime\Email;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;

class MailNotificationHandler implements MessageHandlerInterface
{
    private MailerInterface $mailer;

    /**
     * MailNotificationHandler constructor.
     * @param MailerInterface $mailer
     */
    public function __construct(MailerInterface $mailer)
    {

        $this->mailer = $mailer;
    }

    /**
     * @param MailNotification $message
     * @return bool
     */
    public function __invoke(MailNotification $message): bool
    {
        $email = (new TemplatedEmail())
            ->from($message->getFrom())
            ->to($message->getTo())
            ->subject($message->getSubject())
            ->htmlTemplate( $message->getTemplate())
            ->context($message->getParameters());

        try {
            $this->mailer->send($email);
            // dd($test);
            // $this->mailer->send($email);
            return true;
        } catch (TransportExceptionInterface $e) {
            dd($e);
            return false;
        }
    }
}