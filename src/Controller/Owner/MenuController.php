<?php

declare(strict_types=1);

namespace App\Controller\Owner;

use App\Entity\Menu;
use App\Entity\Owner;
use App\Form\MenuType;
use App\Repository\RestaurantRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route(name: 'menu_owner_')]
final class MenuController extends AbstractController
{
    public function __construct(protected EntityManagerInterface $entityManager, protected RestaurantRepository $restaurantRepository)
    {
    }

    #[Route('/espace-restaurant/{idRestaurant}/ajouter-sont-menu', name: 'create')]
    public function createMenu(int $idRestaurant, Request $request)
    {
        /** @var Owner $owner */
        $owner = $this->getUser();
        /* @phpstan-ignore-next-line  */
        if (!$owner) {
            $this->addFlash('warning', 'Erreur, vous devez être connecter');
            return $this->redirectToRoute('security_owner_login');
        }
        $restaurant = $this->restaurantRepository->findOneById($idRestaurant);
        if (!$restaurant) {
            $this->addFlash('warning', "Erreur, ce Restaurant n'existe pas");
            return $this->redirectToRoute('security_owner_login');
        }
        if ($restaurant->getOwner() !== $owner) {
            $this->addFlash('danger', "Vous n'êtes pas le propriétaire de se restaurant");
            return $this->redirectToRoute('security_owner_login');
        }
        $menu = new Menu();
        $form = $this->createForm(MenuType::class, $menu)->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $menu->setRestaurant($restaurant);
            $this->entityManager->persist($restaurant);
            $this->entityManager->flush();
            $this->addFlash('success', "Le menu a bien été ajouter");
            return $this->redirectToRoute('homePage'); // TODO Redirect to restaurant
        }
        return $this->render('owner/restaurant/menu/create.html.twig', [
            'form' => $form->createView()
        ]);
    }

}