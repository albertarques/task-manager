<?php

namespace App\Command;

use App\Enum\TaskStatusEnum;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:clear-old-tasks',
    description: 'Add a short description for your command',
)]
class ClearOldTasksCommand extends Command
{
    protected static $defaultName = 'app:clear-old-tasks';
    protected static $defaultDescription = 'Elimina las tareas completadas hace más de 30 días.';
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;

        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln('<info>Iniciando limpieza de tareas completadas...</info>');

        // Consulta para obtener tareas COMPLETED hace más de 30 días
        $limitDate = new \DateTimeImmutable('-30 days');
        $repository = $this->entityManager->getRepository(\App\Entity\Task::class);

        $oldTasks = $repository->createQueryBuilder('t')
            ->where('t.status = :status')
            ->andWhere('t.updatedAt <= :limitDate') // Asegúrate de que existe una propiedad updatedAt o similar
            ->setParameter('status', TaskStatusEnum::COMPLETED->value)
            ->setParameter('limitDate', $limitDate)
            ->getQuery()
            ->getResult();

        $countDeleted = 0;

        foreach ($oldTasks as $task) {
            $this->entityManager->remove($task);
            $countDeleted++;
        }

        // Persistir los cambios en la base de datos
        $this->entityManager->flush();

        $output->writeln("<info>Se han eliminado $countDeleted tareas completadas.</info>");

        return Command::SUCCESS;
    }
}
