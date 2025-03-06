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

        foreach ($projets as $projetIndex => $projet) {
            foreach ($statuts as $statutIndex => $libelle) {
                $statut = new Statut();
                $statut->setLibelle($libelle);
                $statut->setProjet($projet);

                $manager->persist($statut);

                // Ajouter une référence unique pour chaque statut de chaque projet
                $this->addReference("statut_{$projetIndex}_{$statutIndex}", $statut);
            }
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
