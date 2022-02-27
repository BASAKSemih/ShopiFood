<?php

declare(strict_types=1);

namespace App\Tests\Functional\User;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;

final class RegistrationTest extends WebTestCase
{
    public function testSuccessRegistrationUser(): void
    {
        $client = static::createClient();
        /** @var RouterInterface $router */
        $router = $client->getContainer()->get('router');
        $crawler = $client->request(Request::METHOD_GET, $router->generate('security_user_register'));

        $form = $crawler->filter('form[name=user]')->form([
            'user[email]' => 'user@user.com',
            'user[firstName]' => 'user',
            'user[lastName]' => 'user',
            'user[password][first]' => 'password',
            'user[password][second]' => 'password',
        ]);
        $client->submit($form);
        $client->followRedirect();
        self::assertRouteSame('homePage');
    }
}
