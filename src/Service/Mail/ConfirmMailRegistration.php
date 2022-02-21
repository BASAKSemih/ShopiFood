<?php

declare(strict_types=1);

namespace App\Service\Mail;

use App\Entity\Owner;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;

final class ConfirmMailRegistration
{
    public function __construct(protected MailerInterface $mailer)
    {
    }

    public function sendConfirmRegistration(Owner $owner): void
    {
        $email = (new TemplatedEmail())
                    ->from('semihbasak25@gmail.com')
                    ->to($owner->getEmail())
                    ->subject('Inscription réussite')
                    ->htmlTemplate('mail/owner/confirm_account.html.twig')
                    ->context(['owner' => $owner, 'token' => $owner->getEmailToken()]);
        $this->mailer->send($email);
    }
}
