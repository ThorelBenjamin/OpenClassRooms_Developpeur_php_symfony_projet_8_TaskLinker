<?php

namespace App\DataFixtures;

use App\Entity\Etiquette;
use App\Entity\Projet;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Faker\Factory;

class EtiquetteFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        $projets = $manager->getRepository(Projet::class)->findAll();

        for ($i = 0; $i < 10; $i++) {
            $etiquette = new Etiquette();
            $etiquette->setLibelle($faker->word());

            if (count($projets) > 0) {
                $etiquette->setProjet($projets[array_rand($projets)]);
            }

            $this->addReference("etiquette_$i", $etiquette);
            $manager->persist($etiquette);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            ProjetFixtures::class,
        ];
    }
}