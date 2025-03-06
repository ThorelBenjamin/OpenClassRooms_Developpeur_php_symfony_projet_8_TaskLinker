<?php

namespace App\DataFixtures;

use App\Entity\Employe;
use App\Entity\Tache;
use App\Entity\Projet;
use App\Entity\Statut;
use App\Entity\Etiquette;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Faker\Factory;

class TacheFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        $etiquettes = $manager->getRepository(Etiquette::class)->findAll();

        for ($i = 0; $i < 20; $i++) {
            $tache = new Tache();

            // Récupérer un projet au hasard
            $projetIndex = mt_rand(0, 4);
            $projet = $this->getReference("projet_" . $projetIndex, Projet::class);

            // Récupérer un statut au hasard pour ce projet
            $statutIndex = mt_rand(0, 2);
            $statut = $this->getReference("statut_{$projetIndex}_{$statutIndex}", Statut::class);

            $tache->setTitre($faker->sentence(3))
                ->setDescription($faker->paragraph(2))
                ->setDeadline($faker->optional(0.7)->dateTimeBetween('now', '+1 year'))
                ->setEmploye($this->getReference("employe_" . mt_rand(0, 9), Employe::class))
                ->setProjet($projet)
                ->setStatut($statut);

            // Ajouter des étiquettes aléatoires
            for ($j = 0; $j < mt_rand(1, 3); $j++) {
                if (!empty($etiquettes)) {
                    $tache->addEtiquette($etiquettes[array_rand($etiquettes)]);
                }
            }

            $this->addReference("tache_$i", $tache);
            $manager->persist($tache);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            EmployeFixtures::class,
            ProjetFixtures::class,
            StatutFixtures::class,
            EtiquetteFixtures::class,
        ];
    }
}