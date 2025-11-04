<?php

namespace App\DataFixtures;

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
        $t1 = new Team();
        $t1->setUsername('Les bests');
        $t1->setPassword('team123');
        $t1->setRoles(['ROLE_USER']);
        $t1->setCreationDate(new \DateTime('now'));
        $manager->persist($t1);

        $manager->flush();
    }
}
