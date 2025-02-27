<?php

namespace App\DataFixtures;

use App\Entity\Employe;
use App\Entity\Projet;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class ProjetFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        $projects = [];

        for ($i = 0; $i < 5; $i++) {
            $projet = new Projet();
            $projet->setNom($faker->sentence(3))
                ->setDateDemarrage($faker->dateTimeBetween('-1 year', 'now'))
                ->setDeadline($faker->dateTimeBetween('now', '+1 year'))
                ->setArchive($faker->boolean() ? 1 : 0);

            $employeIds = range(0, 9);
            shuffle($employeIds);

            // Associer entre 2 et 5 employés au projet
            for ($j = 0; $j < mt_rand(2, 5); $j++) {
                $employe = $this->getReference("employe_" . $employeIds[$j], Employe::class);
                $projet->addEmploye($employe);
                $employe->addProjet($projet); // Assurez-vous que l'employé sait à quel projet il est associé
            }
            $this->addReference("projet_" . $i, $projet);
            $manager->persist($projet);
        }

        $manager->flush();
    }

    // Dépendance pour s'assurer que EmployeFixtures soit chargé avant
    public function getDependencies(): array
    {
        return [
            EmployeFixtures::class,
        ];
    }
}