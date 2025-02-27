<?php

namespace App\DataFixtures;

use App\Entity\Statut;
use App\Entity\Projet;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class StatutFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $projets = $manager->getRepository(Projet::class)->findAll();
        $statuts = ['À faire', 'En cours', 'Terminé'];

        foreach ($statuts as $index => $libelle) {
            $statut = new Statut();
            $statut->setLibelle($libelle);

            if (count($projets) > 0) {
                $statut->setProjet($projets[array_rand($projets)]);
            }

            $manager->persist($statut);
            $this->addReference("statut_" . $index, $statut);
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