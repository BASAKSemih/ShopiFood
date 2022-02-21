<?php

declare(strict_types=1);

namespace App\Controller\Owner;

use App\Entity\Owner;
use App\Entity\Restaurant;
use App\Form\RestaurantType;
use App\Repository\OwnerRepository;
use App\Repository\RestaurantRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route(name: 'restaurant_owner_')]
final class RestaurantController extends AbstractController
{
    public function __construct(
        protected EntityManagerInterface $entityManager,
        protected OwnerRepository $ownerRepository,
        protected RestaurantRepository $restaurantRepository
    ) {
    }

    #[Route('/espace-restaurant/cree-sont-restaurant', name: 'create')]
    public function createRestaurant(Request $request)
    {
        /** @var Owner $owner */
        $owner = $this->getUser();
        if (!$owner)
        {
            $this->addFlash('warning', "Erreur, vous devez être connecter");
            return $this->redirectToRoute('security_owner_login');
        }
        if ($owner->getRestaurant()) {
            $this->addFlash('warning', "Erreur, vous avez déjà crée votre restaurant");
            return $this->redirectToRoute('security_owner_login');
        }
        $restaurant = new Restaurant();
        $form = $this->createForm(RestaurantType::class, $restaurant)->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $restaurant->setOwner($owner);
            $this->entityManager->persist($restaurant);
            $this->entityManager->flush();
            $this->addFlash('success', "Votre restaurant à été crée");
            return $this->redirectToRoute('homePage'); //TODO redirect to restaurant show
        }
        return $this->render('owner/restaurant/create.html.twig', [
            'form' => $form->createView()
        ]);
    }
}