<?php

namespace App\Controller;

use App\Entity\Task;
use App\Form\TaskType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class TaskController extends AbstractController
{
    #[Route('/tasks', name: 'app_task_index', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        if(!$user instanceof \App\Entity\User) {
            throw $this->createAccessDeniedException('You need to be logged in to access this page.');
        }

        $tasks = $entityManager->getRepository(Task::class)->findAllByUserOrderByStatusAndDuedate($user);

        return $this->render('task/index.html.twig', [
            'tasks' => $tasks,
            'user' => $user,
        ]);
    }

    #[Route('/tasks/new', name: 'app_task_new', methods: ['GET', 'POST'])]
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        $task = new Task();
        $form = $this->createForm(TaskType::class, $task);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $task->setUser($user);
            $task->setCreatedAt(new \DateTimeImmutable());
            $entityManager->persist($task);
            $entityManager->flush();

            return $this->redirectToRoute('app_task_index');
        }

        return $this->render('task/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/tasks/{id}/edit', name: 'app_task_edit', methods: ['GET', 'POST'])]
    public function edit(Task $task, Request $request, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('TASK_EDIT', $task);

        $form = $this->createForm(TaskType::class, $task);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            return $this->redirectToRoute('app_task_index');
        }

        return $this->render('task/edit.html.twig', [
            'form' => $form->createView(),
            'task' => $task,
        ]);
    }

    #[Route('/tasks/{id}/delete', name: 'app_task_delete', methods: ['POST'])]
    public function delete(Task $task, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('TASK_DELETE', $task);

        $entityManager->remove($task);
        $entityManager->flush();

        return $this->redirectToRoute('app_task_index');
    }

    #[Route('/tasks/{id}', name: 'app_task_complete', methods: ['POST', 'GET'])]
    public function complete(Task $task, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('TASK_EDIT', $task);

        $task->setStatus(\App\Enum\TaskStatusEnum::COMPLETED);
        $entityManager->persist($task);
        $entityManager->flush();

        $this->addFlash('success', 'Task marked as completed!');

        return $this->redirectToRoute('app_task_index');
    }
}
