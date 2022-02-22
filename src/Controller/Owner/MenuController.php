<?php

declare(strict_types=1);

namespace App\Controller\Owner;

use App\Entity\Menu;
use App\Entity\Owner;
use App\Entity\Restaurant;
use App\Form\MenuType;
use App\Repository\RestaurantRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route(name: 'menu_owner_')]
final class MenuController extends AbstractController
{
    public function __construct(protected EntityManagerInterface $entityManager, protected RestaurantRepository $restaurantRepository, protected SluggerInterface $slugger)
    {
    }

    #[Route('/espace-restaurant/{idRestaurant}/ajouter-sont-menu', name: 'create')]
    public function createMenu(int $idRestaurant, Request $request):Response
    {
        /** @var Owner $owner */
        $owner = $this->getUser();
        /* @phpstan-ignore-next-line  */
        if (!$owner) {
            $this->addFlash('warning', 'Erreur, vous devez être connecter');
            return $this->redirectToRoute('security_owner_login');
        }
        /** @var Restaurant $restaurant */
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
            $menu->setSlug((string)$this->slugger->slug($menu->getName()));
            $this->entityManager->persist($menu);
            $this->entityManager->flush();
            $this->addFlash('success', "Le menu a bien été ajouter");
            return $this->redirectToRoute('menu_owner_create', ['idRestaurant' => $restaurant->getId()]); // TODO Redirect to restaurant
        }
        return $this->render('owner/restaurant/menu/create.html.twig', [
            'form' => $form->createView()
        ]);
    }

}