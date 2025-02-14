<?php

namespace App\DataFixtures;

use App\Entity\Task;
use App\Entity\Enum\TaskStatusEnum;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class TaskFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 1; $i <= 10; $i++) {
            $task = new Task();
            $task->setTitle("Tarea $i");
            $task->setDescription("Descripción de la tarea $i");
            $task->setDueDate((new \DateTime())->modify("+$i days"));

            // Selecciona un caso aleatorio de TaskStatusEnum
            $statuses = TaskStatusEnum::cases();
            $randomStatus = $statuses[array_rand($statuses)];
            $task->setStatus($randomStatus);

            $manager->persist($task);
        }

        $manager->flush();
    }
}
