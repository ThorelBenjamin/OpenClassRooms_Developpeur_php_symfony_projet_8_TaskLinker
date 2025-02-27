<?php

namespace App\DataFixtures;

use App\Entity\Employe;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Faker\Factory;

class EmployeFixtures extends Fixture
{

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        for($i = 0; $i < 10; $i++){
            $employe = new Employe();
            $employe->setNom($faker->firstName())
                ->setPrenom($faker->lastName())
                ->setEmail($faker->email())
                ->setRole($faker->numberBetween(1,2))
                ->setContrat($faker->randomElement(['CDI', 'CDD', 'Freelance']))
                ->setDateArrivee($faker->dateTimeBetween('-2 years', 'now'))
                ->setActif($faker->numberBetween(0, 1));

            $password = $this->passwordHasher->hashPassword($employe, '1234');
            $employe->setPassword($password);

            $manager->persist($employe);

            $this->addReference("employe_" . $i, $employe);
        }

        $manager->flush();
    }
}
