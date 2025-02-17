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
        // TODO: If User is logged send to user task list, if not send to login/register view
        return $this->render('/home.html.twig', [
            'controller_name' => 'HomeController',
            'title' => 'Home',
            'page' => 'home',
            'tasks' => $tr->findAll(),
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
        return $this->render('register.html.twig', [
            'controller_name' => 'RegisterController',
        ]);
    }

}
