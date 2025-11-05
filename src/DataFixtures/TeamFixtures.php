<?php

namespace App\DataFixtures;

use App\Entity\Game;
use App\Entity\Team;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class TeamFixtures extends Fixture
{
    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager): void
    {
        $game = (new Game())
            ->setFinished(false)
            ->setStartDate(new \DateTime('now'));

        $team = new Team();
        $team->setUsername('LesBests');
        $team->setRoles(['ROLE_USER']);
        $team->setCreationDate(new \DateTime('now'));
        $team->setPassword($this->hasher->hashPassword($team, 'team123'));
        $team->setGame($game);

        $manager->persist($team);

        $manager->flush();
    }
}
