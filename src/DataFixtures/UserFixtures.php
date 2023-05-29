<?php

namespace App\DataFixtures;

use App\Entity\Utilisateur;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();

        // Créer un utilisateur avec un rôle d'administrateur
        $admin = new Utilisateur();
        $admin->setEmail('admin@example.com');
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setPassword($this->passwordEncoder->encodePassword($admin, 'admin')); // Utiliser le processus de hachage pour le mot de passe
        $manager->persist($admin);

        for ($i = 0; $i < 10; $i++) {
            $user = new Utilisateur();
            $user->setEmail($faker->email);
            $user->setRoles(['ROLE_USER']);
            $user->setPassword($this->passwordEncoder->encodePassword($user, 'password'));
            // ... définir d'autres propriétés de l'utilisateur selon vos besoins

            $manager->persist($user);
        }

        $manager->flush();
    }
}
