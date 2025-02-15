<?php

namespace App\Controller;

use App\Repository\TaskRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/')]
    public function index(TaskRepository $tr): Response
    {
        return $this->render('/home.html.twig', [
            'controller_name' => 'HomeController',
            'title' => 'Home',
            'page' => 'home',
            'tasks' => $tr->findAllSortedByCreatedAtQB(),
        ]);
    }
}
