<?php

declare(strict_types=1);

namespace App\Tests\Functional\Owner\Restaurant;

use App\Entity\Restaurant;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;

final class CreateMenuTest extends WebTestCase
{
    public function testCreateMenu(): void
    {
        $client = static::createClient();
        /** @var RouterInterface $router */
        $router = $client->getContainer()->get('router');
        $crawler = $client->request(Request::METHOD_GET, $router->generate('security_owner_login'));
        $form = $crawler->filter('form[name=login]')->form([
            'email' => 'semihbasak@gmail.com',
            'password' => '12',
        ]);
        $client->submit($form);
        $client->followRedirect();
        self::assertRouteSame('homePage');

        $entityManager = $client->getContainer()->get('doctrine.orm.entity_manager');
        $restaurantRepository = $entityManager->getRepository(Restaurant::class);
        /** @var Restaurant $restaurant */
        $restaurant = $restaurantRepository->findOneByName('Super-Resto');
        $crawler = $client->request(Request::METHOD_GET, $router->generate('restaurant_menu_owner_create', [
            'idRestaurant' => $restaurant->getId(),
        ]));
        self::assertRouteSame('restaurant_menu_owner_create');
        $form = $crawler->filter('form[name=menu]')->form([
            'menu[name]' => 'menu name',
            'menu[price]' => 2323,
            'menu[description]' => 'menu description',
            'menu[category]' => 1,
        ]);
        $client->submit($form);
        $client->followRedirect();
        self::assertRouteSame('homePage');
    }
}
