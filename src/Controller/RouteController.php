<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\TaskRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class RouteController extends AbstractController
{
    #[Route('/')]
    public function index(TaskRepository $tr): Response
    {
        return $this->render('/index.html.twig', [
            'controller_name' => 'RouteController',
            'title' => 'Home',
            'page' => 'home',
        ]);
    }

    #[Route('/tasks/user/{id}', name: 'tasks_by_user')]
    public function getTasksByUser(User $user, TaskRepository $taskRepository): Response
    {
        $tasks = $taskRepository->findByUser($user);

        return $this->render('tasks_by_user.html.twig', [
            'tasks' => $tasks,
            'user' => $user,
        ]);
    }

    #[Route('/login', name: 'login')]
    public function login(): Response
    {
        return $this->render('login.html.twig', [
            'controller_name' => 'LoginController',
        ]);
    }

    #[Route('/register', name: 'register')]
    public function register(): Response
    {
        return $this->render('register_new_user.html.twig', [
            'controller_name' => 'RegisterController',
        ]);
    }

}
