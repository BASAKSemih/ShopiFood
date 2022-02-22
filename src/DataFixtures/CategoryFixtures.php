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
        $category->setSlug((string) $this->slugger->slug($category->getName()));
        $manager->persist($category);

        $category2 = new Category();
        $category2->setName('Tacos');
        $category2->setSlug((string) $this->slugger->slug($category2->getName()));
        $manager->persist($category2);
        $manager->flush();

        $category3 = new Category();
        $category3->setName('Burgers');
        $category3->setSlug((string) $this->slugger->slug($category3->getName()));
        $manager->persist($category3);
        $manager->flush();
    }
}
