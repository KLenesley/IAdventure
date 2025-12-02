<?php

namespace App\DataFixtures;

use App\Entity\Avatar;
use App\Entity\Type;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // Create enigma types
        $types = [
            'QCM' => 'Questionnaire à choix multiples',
            'Carte' => 'Carte interactive',
            'Vidéo' => 'Vidéo',
            'Photo' => 'Photo',
            'Timeline' => 'Ligne temporelle',
            'Association' => 'Association d\'éléments',
            'Classification' => 'Classification',
            'Comparaison' => 'Comparaison',
            'Vrai/Faux' => 'Vrai ou Faux',
            'Code' => 'Code à trouver',
        ];

        foreach ($types as $label => $description) {
            $type = new Type();
            $type->setLabel($label);
            $manager->persist($type);
        }

        // Create sample avatars
        $avatars = [
            'robot.png',
            'astronaut.png',
            'detective.png',
            'scientist.png',
            'explorer.png',
        ];

        foreach ($avatars as $filename) {
            $avatar = new Avatar();
            $avatar->setFilename($filename);
            $manager->persist($avatar);
        }

        $manager->flush();
    }
}
