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
}
