<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setEmail('user@gmail.com');
        $user->setPassword($this->hasher->hashPassword($user, 'user'));
        $user->setRoles(['ROLE_USER']);
        $user->setIsVerified(true);
        $manager->persist($user);

        $prof = new User();
        $prof->setEmail('prof@gmail.com');
        $prof->setRoles(['ROLE_PROF']);
        $prof->setPassword($this->hasher->hashPassword($prof, 'prof'));
        $prof->setIsVerified(true);
        $manager->persist($prof);

        $admin = new User();
        $admin->setEmail('admin@gmail.com');
        $admin->setPassword($this->hasher->hashPassword($admin, 'admin'));
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setIsVerified(true);
        $manager->persist($admin);

        $superAdmin = new User();
        $superAdmin->setEmail('s-admin@gmail.com');
        $superAdmin->setPassword($this->hasher->hashPassword($superAdmin, 's-admin'));
        $superAdmin->setRoles(['ROLE_SUPER_ADMIN']);
        $superAdmin->setIsVerified(true);
        $manager->persist($superAdmin);

        $manager->flush();
    }
}
