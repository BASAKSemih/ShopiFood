<?php

declare(strict_types=1);

namespace App\Tests\Functional\Owner;

use App\Entity\Owner;
use App\Repository\OwnerRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;

final class RegistrationTest extends WebTestCase
{
    public function testSuccessRegistrationOwner(): void
    {
        $client = static::createClient();
        /** @var RouterInterface $router */
        $router = $client->getContainer()->get('router');
        $crawler = $client->request(Request::METHOD_GET, $router->generate('security_owner_register'));

        $form = $crawler->filter('form[name=owner]')->form([
            'owner[email]' => 'user@user.com',
            'owner[firstName]' => 'John',
            'owner[lastName]' => 'Doe',
            'owner[phoneNumber]' => '0754201565',
            'owner[password][first]' => 'password',
            'owner[password][second]' => 'password',
        ]);
        $client->submit($form);
        $client->followRedirect();
        self::assertRouteSame('homePage');
    }

    public function testSuccessConfirmAccountOwner(): void
    {
        $client = static::createClient();
        /** @var RouterInterface $router */
        $router = $client->getContainer()->get('router');
        $entityManager = $client->getContainer()->get('doctrine.orm.entity_manager');
        /** @var OwnerRepository $ownerRepository */
        $ownerRepository = $entityManager->getRepository(Owner::class);
        $owner = $ownerRepository->findOneByEmail('user@user.com');
        $crawler = $client->request(Request::METHOD_GET, $router->generate('security_owner_confirm_account', [
           'idEmailToken' => $owner->getEmailToken(),
        ]));
        $client->followRedirect();
        self::assertRouteSame('homePage');
    }
}
