<?php

namespace App\Controller;

use App\Entity\Dish;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(ManagerRegistry $managerRegistry): Response
    {
        return $this->render('home/index.html.twig', [
        ]);
    }

    public function findByCategory(ManagerRegistry $managerRegistry, string $category): array
    {
        return $managerRegistry->getManager()->getRepository(DishController::class)->findBy(['category' => $category]);
    }
}
