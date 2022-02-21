<?php

declare(strict_types=1);

namespace App\Tests\Functional\Owner\Restaurant;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;

final class CreateRestaurantTest extends WebTestCase
{
    public function testCreateRestaurant(): void
    {
        $client = static::createClient();
        /** @var RouterInterface $router */
        $router = $client->getContainer()->get('router');
        $crawler = $client->request(Request::METHOD_GET, $router->generate('security_owner_login'));
        $form = $crawler->filter('form[name=login]')->form([
            'email' => 'david@john.com',
            'password' => 'password',
        ]);
        $client->submit($form);
        $client->followRedirect();
        self::assertRouteSame('homePage');
        $crawler = $client->request(Request::METHOD_GET, $router->generate('restaurant_owner_create'));
        self::assertRouteSame('restaurant_owner_create');
        $form = $crawler->filter('form[name=restaurant]')->form([
            'restaurant[name]' => 'name',
            'restaurant[description]' => 'description',
            'restaurant[stripePublicKey]' => 'stripePublicKey',
            'restaurant[stripePrivateKey]' => 'stripePrivateKey',

        ]);
        $client->submit($form);
        $client->followRedirect();
        self::assertRouteSame('homePage');
    }

}