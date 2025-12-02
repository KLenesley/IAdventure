<?php

namespace App\Repository;

use App\Entity\GameSession;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<GameSession>
 */
class GameSessionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GameSession::class);
    }

    public function findActiveSessionsByGame(int $gameId): array
    {
        return $this->createQueryBuilder('gs')
            ->andWhere('gs.game = :game')
            ->andWhere('gs.status = :status')
            ->setParameter('game', $gameId)
            ->setParameter('status', 'in_progress')
            ->orderBy('gs.startedAt', 'DESC')
            ->getQuery()
            ->getResult();
    }
}
