<?php

namespace App\Repository;

use App\Entity\Game;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Game>
 */
class GameRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Game::class);
    }

    public function findByCreator(int $creatorId): array
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.creator = :creator')
            ->setParameter('creator', $creatorId)
            ->orderBy('g.title', 'ASC')
            ->getQuery()
            ->getResult();
    }
}
