<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\TaskRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/')]
    public function index(Security $security): Response
    {
        $user = $security->getUser();

        return $this->render('/index.html.twig', [
            'controller_name' => 'RouteController',
            'title' => 'Home',
            'page' => 'home',
            'user' => $user,
        ]);
    }
}
