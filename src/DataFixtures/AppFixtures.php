<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        $this->loadAnnonces($manager);
        $this->loadUsers($manager);
    }

    private function loadAnnonces(ObjectManager $manager)
    {
        $annonceFixtures = new AnnonceFixtures();
        $annonceFixtures->load($manager);
    }

    private function loadUsers(ObjectManager $manager)
    {
        $userFixtures = new UserFixtures($this->passwordEncoder);
        $userFixtures->load($manager);
    }
}
