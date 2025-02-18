<?php

namespace App\DataFixtures;

use App\Entity\Task;
use App\Enum\TaskStatusEnum;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class TaskFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 1; $i <= 10; $i++) {
            $task = new Task();
            $task->setTitle("Tarea $i");
            $task->setDescription("Descripción de la tarea $i");
            $task->setDueDate((new \DateTime())->modify("+$i days"));

            $statuses = TaskStatusEnum::cases();
            $randomStatus = $statuses[array_rand($statuses)];
            $task->setStatus($randomStatus);

            // Obtener y asignar un usuario aleatorio
            $randomUser = $this->getRandomUserReference();

            $task->setUser($randomUser);
            $manager->persist($task);
        }

        $userRepository = $manager->getRepository(User::class);
        $user = $userRepository->findOneBy(['email' => 'albertarques@gmail.com']);

        for ($i = 1; $i <= 5; $i++) {
            $task = new Task();
            $task->setTitle("Tarea ejemplo $i");
            $task->setDescription("Descripción de la tarea $i para el usuario albertarques@gmail.com");
            $task->setDueDate((new \DateTime())->modify("+$i days"));

            $statuses = TaskStatusEnum::cases();
            $randomStatus = $statuses[array_rand($statuses)];
            $task->setStatus($randomStatus);

            $task->setUser($user);
            $manager->persist($task);
        }


        $manager->flush();
    }

    /**
     * Devuelve una referencia de un usuario aleatorio.
     */
    private function getRandomUserReference(): User
    {
        $randomEmail = "user-" . random_int(1, 5) . "@example.com";
        return $this->getReference($randomEmail, User::class);
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
        ];
    }
}
