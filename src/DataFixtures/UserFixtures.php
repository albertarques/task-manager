<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 1; $i <= 10; $i++) {
            $user = new User();
            $user->setEmail("usuario$i@example.com");
            $user->setPassword(password_hash("password$i", PASSWORD_BCRYPT));

            $manager->persist($user);
        }

        $user = new User();
        $user->setEmail("albertarques@gmail.com");
        $user->setPassword(password_hash("superadmin", PASSWORD_BCRYPT));
        $manager->persist($user);

        $manager->flush();
    }
}
