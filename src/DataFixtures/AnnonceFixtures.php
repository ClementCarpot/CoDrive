<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use App\Entity\Annonce;

class AnnonceFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

        for ($i = 0; $i < 10; $i++) {
            $annonce = new Annonce();
            $annonce->setVilleDepart($faker->city);
            $annonce->setVilleArrive($faker->city);
            $annonce->setPrix($faker->randomFloat(2, 10, 100));
            $annonce->setHeureDepart(new \DateTime($faker->time()));
            $annonce->setDateDepart($faker->dateTimeBetween('+1 week', '+2 weeks'));
            $annonce->setVehicule($faker->randomElement(['BMW Serie 3', 'AUDI R8', 'Renault Scenic', 'Peugeot 306']));
            // Définir d'autres propriétés de l'entité Annonce

            $manager->persist($annonce);
        }

        $manager->flush();
    }
}
