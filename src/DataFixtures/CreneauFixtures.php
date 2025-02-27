<?php

namespace App\DataFixtures;

use App\Entity\Creneau;
use App\Entity\Employe;
use App\Entity\Tache;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Faker\Factory;

class CreneauFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        for ($i = 0; $i < 10; $i++) {
            $creneau = new Creneau();
            $creneau->setDebut($faker->dateTimeBetween('now', '+1 week'))
                ->setFin($faker->dateTimeBetween('+1 week', '+2 weeks'))
                ->setEmploye($this->getReference("employe_" . mt_rand(0, 9), Employe::class))
                ->setTache($this->getReference("tache_" . mt_rand(0, 19), Tache::class));

            $manager->persist($creneau);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            TacheFixtures::class,
            EmployeFixtures::class,
        ];
    }
}