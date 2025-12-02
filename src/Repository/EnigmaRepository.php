<?php

namespace App\Repository;

use App\Entity\Enigma;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Enigma>
 */
class EnigmaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Enigma::class);
    }

    public function findByGame(int $gameId): array
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.game = :game')
            ->setParameter('game', $gameId)
            ->orderBy('e.order', 'ASC')
            ->getQuery()
            ->getResult();
    }
}
