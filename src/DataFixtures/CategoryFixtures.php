<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\String\Slugger\SluggerInterface;

final class CategoryFixtures extends Fixture
{
    public function __construct(protected SluggerInterface $slugger)
    {
    }

    public function load(ObjectManager $manager): void
    {
        $category = new Category();
        $category->setName('Pizza');
        $category->setSlug((string)$this->slugger->slug($category->getName()));
        $manager->persist($category);
        $manager->flush();
    }
}