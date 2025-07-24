<?php


namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\User4;

class UserFixtures extends Fixture {

    public function load(ObjectManager $manager):void
    {
        $user = new User4();
        $user->setName("Admin");
        $user->setEmail("admin@example.com");

        $manager->persist($user);
        $manager->flush();
    }
}
