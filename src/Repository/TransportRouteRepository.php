<?php

namespace App\Repository;

use App\Entity\TransportRoute;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TransportRoute|null find($id, $lockMode = null, $lockVersion = null)
 * @method TransportRoute|null findOneBy(array $criteria, array $orderBy = null)
 * @method TransportRoute[]    findAll()
 * @method TransportRoute[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TransportRouteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TransportRoute::class);
    }
}
