<?php

declare(strict_types=1);

namespace App\Controller\Owner\Security;

use App\Entity\Owner;
use App\Form\OwnerType;
use App\Repository\OwnerRepository;
use App\Service\Mail\ConfirmMailRegistration;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route(name: 'security_owner_')]
final class RegistrationController extends AbstractController
{
    public function __construct(
        protected EntityManagerInterface $entityManager,
        protected OwnerRepository $ownerRepository,
        protected UserPasswordHasherInterface $passwordHasher,
    ) {
    }

    #[Route('/espace-restaurant/inscription', name: 'register')]
    public function registration(Request $request, ConfirmMailRegistration $mailRegistration): Response
    {
        if ($this->getUser()) {
            $this->addFlash('warning', 'Vous êtes déjà connecter, vous ne pouvez pas vous inscrire');

            return $this->redirectToRoute('homePage');
        }
        $owner = new Owner();
        $form = $this->createForm(OwnerType::class, $owner)->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $checkExist = $this->ownerRepository->findOneByEmail($owner->getEmail());
            if (!$checkExist) {
                $passwordHash = $this->passwordHasher->hashPassword($owner, $owner->getPassword());
                $owner->setPassword($passwordHash);
                $owner->setEmailToken($this->generateToken());
                $this->entityManager->persist($owner);
                $this->entityManager->flush();
                $mailRegistration->sendConfirmRegistration($owner);
                $this->addFlash('success', "Vous aller recevoir un email pour vérifier votre compte à l'adresse suivante : ".$owner->getEmail());
                return $this->redirectToRoute('homePage'); // TODO Redirect to login route
            }
        }

        return $this->render('owner/security/register.html.twig', ['form' => $form->createView()]);
    }

    private function generateToken(): string
    {
        return rtrim(strtr(base64_encode(random_bytes(32)), '+/', '-_'), '=');
    }
}
