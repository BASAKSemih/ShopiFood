<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Owner;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

final class OwnerFixtures extends Fixture
{
    public function __construct(private UserPasswordHasherInterface $userPasswordHasher)
    {
    }

    public function load(ObjectManager $manager)
    {
        $owner = new Owner();
        $owner
            ->setFirstName('John')
            ->setLastName('Doe')
            ->setIsVerified(true)
            ->setEmail('johndoe@doe.com')
            ->setPhoneNumber('05136456')
            ->setPassword($this->userPasswordHasher->hashPassword($owner, 'password'));

        $manager->persist($owner);
        $manager->flush();
    }
}
