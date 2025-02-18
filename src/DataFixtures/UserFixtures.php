<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        for ($i = 1; $i <= 5; $i++) {
            $user = new User();
            $email = "user-$i@example.com";
            $user->setEmail($email);
            $user->setPassword($this->passwordHasher->hashPassword($user, 'password123'));

            $this->addReference($email, $user);

            $manager->persist($user);
        }

        $user = new User();
        $user->setEmail("albertarques@gmail.com");
        $user->setPassword(password_hash("superadmin", PASSWORD_BCRYPT));
        $manager->persist($user);

        $manager->flush();
    }
}
