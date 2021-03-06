<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Restaurant;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Restaurant|null find($id, $lockMode = null, $lockVersion = null)
 * @method Restaurant|null findOneBy(array $criteria, array $orderBy = null)
 * @method                 findAll()                                                                     array<int, Restaurant>
 * @method                 findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null) array<array-key, Restaurant>
 *
 * @template T
 *
 * @extends ServiceEntityRepository<Restaurant>
 */
final class RestaurantRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Restaurant::class);
    }
}
