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
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route(name: 'restaurant_owner_')]
final class RestaurantController extends AbstractController
{
    public function __construct(
        protected EntityManagerInterface $entityManager,
        protected OwnerRepository $ownerRepository,
        protected RestaurantRepository $restaurantRepository,
        protected SluggerInterface $slugger
    ) {
    }

    #[Route('/espace-restaurant/cree-sont-restaurant', name: 'create')]
    public function createRestaurant(Request $request): Response
    {
        /** @var Owner $owner */
        $owner = $this->getUser();
        /* @phpstan-ignore-next-line  */
        if (!$owner) {
            $this->addFlash('warning', 'Erreur, vous devez être connecter');

            return $this->redirectToRoute('security_owner_login');
        }
        if ($owner->getRestaurant()) {
            $this->addFlash('warning', 'Erreur, vous avez déjà crée votre restaurant');

            return $this->redirectToRoute('homePage');
        }
        $restaurant = new Restaurant();
        $form = $this->createForm(RestaurantType::class, $restaurant)->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $restaurant->setOwner($owner);
            /* @phpstan-ignore-next-line  */
            $restaurant->setSlug((string) $this->slugger->slug($restaurant->getName()));
            $this->entityManager->persist($restaurant);
            $this->entityManager->flush();
            $this->addFlash('success', 'Votre restaurant à été crée');

            return $this->redirectToRoute('homePage'); //TODO redirect to restaurant show
        }

        return $this->render('owner/restaurant/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
