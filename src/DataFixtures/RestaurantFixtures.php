<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Owner;
use App\Entity\Restaurant;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\String\Slugger\SluggerInterface;

final class RestaurantFixtures extends Fixture
{
    public function __construct(protected UserPasswordHasherInterface $userPasswordHasher, protected SluggerInterface $slugger)
    {
    }

    public function load(ObjectManager $manager): void
    {
        $owner = new Owner();
        $owner
            ->setFirstName('Max')
            ->setLastName('Doe')
            ->setIsVerified(true)
            ->setEmail('semihbasak@gmail.com')
            ->setPhoneNumber('05136456')
            ->setPassword($this->userPasswordHasher->hashPassword($owner, '12'));

        $manager->persist($owner);
        $manager->flush();

        $restaurant = new Restaurant();
        $restaurant
            ->setName('Super-Resto')
            ->setOwner($owner)
            ->setDescription('lorem')
            ->setSlug((string)$this->slugger->slug($restaurant->getName()))
            ->setStripePrivateKey('privatekey')
            ->setStripePublicKey('publicKey');
        $manager->persist($restaurant);
        $manager->flush();
    }
}