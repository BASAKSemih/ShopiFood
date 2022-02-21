<?php

namespace App\Tests\Functional\Owner\Security;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;

class AuthenticationTest extends WebTestCase
{
    public function testOwnerLoginWithConfirmedAccount(): void
    {
        $client = static::createClient();
        /** @var RouterInterface $router */
        $router = $client->getContainer()->get('router');
        $crawler = $client->request(Request::METHOD_GET, $router->generate('security_owner_login'));
        $form = $crawler->filter('form[name=login]')->form([
            'email' => 'johndoe@doe.com',
            'password' => 'password',
        ]);

        $client->submit($form);
        $client->followRedirect();
        self::assertRouteSame('homePage');
    }
}
