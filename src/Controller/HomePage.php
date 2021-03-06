<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class HomePage extends AbstractController
{
    #[Route('/', name: 'homePage')]
    public function home(): Response
    {
        $user->setPassword($newPassword)
        $this->entityManager->flush();
        return $this->render('home/index.html.twig');
    }
}
