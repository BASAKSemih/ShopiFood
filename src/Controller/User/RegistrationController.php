<?php

declare(strict_types=1);

namespace App\Controller\User;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use App\Service\Mail\ConfirmMailRegistration;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route(name: 'security_user_')]
final class RegistrationController extends AbstractController
{
    public function __construct(protected UserRepository $userRepository, protected EntityManagerInterface $entityManager, protected UserPasswordHasherInterface $passwordHasher)
    {
    }

    #[Route('/espace-utilisateur/inscription', name: 'register')]
    public function registration(Request $request, ConfirmMailRegistration $mailRegistration): Response
    {
        if ($this->getUser()) {
            $this->addFlash('warning', 'Vous êtes déjà connecter, vous ne pouvez pas vous inscrire');

            return $this->redirectToRoute('homePage');
        }
        $user = new User();
        $form = $this->createForm(UserType::class, $user)->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $checkExist = $this->userRepository->findOneByEmail($user->getEmail());
            if (!$checkExist) {
                $passwordHash = $this->passwordHasher->hashPassword($user, $user->getPassword());
                $user->setPassword($passwordHash);
                $user->setEmailToken($this->generateToken());
                $this->entityManager->persist($user);
                $this->entityManager->flush();
                $mailRegistration->sendConfirmRegistration($user);
                $this->addFlash('success', "Vous aller recevoir un email pour vérifier votre compte à l'adresse suivante : ".$user->getEmail());

                return $this->redirectToRoute('homePage'); // TODO Redirect to login route
            }
        }

        return $this->render('user/register.html.twig', ['form' => $form->createView()]);
    }

    private function generateToken(): string
    {
        return rtrim(strtr(base64_encode(random_bytes(32)), '+/', '-_'), '=');
    }

}