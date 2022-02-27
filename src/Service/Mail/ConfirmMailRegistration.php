<?php

declare(strict_types=1);

namespace App\Service\Mail;

use App\Entity\Owner;
use App\Entity\User;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;

final class ConfirmMailRegistration
{
    public function __construct(protected MailerInterface $mailer)
    {
    }

    public function sendConfirmRegistration(User|Owner $entity): void
    {
        $email = (new TemplatedEmail())
            ->from('semihbasak25@gmail.com')
            ->to($entity->getEmail())
            ->subject('Inscription réussite')
            ->htmlTemplate('mail/owner/confirm_account.html.twig')
            ->context(['owner' => $entity, 'token' => $entity->getEmailToken()]);
        $this->mailer->send($email);
    }
}
