<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Dish;
use App\Entity\Schedule;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FullMenuController extends AbstractController
{
    #[Route('/full-menu', name: 'app_full_menu')]
    public function index(ManagerRegistry $managerRegistry): Response
    {
        $em = $managerRegistry->getManager();

        $dishes = $em->getRepository(Dish::class)->findAll();
        $categories = $em->getRepository(Category::class)->findAll();

        $days = $em->getRepository(Schedule::class)->findAll();
        return $this->render('full_menu/index.html.twig', [
            'days' => $days,
            'dishes' => $dishes,
            'categories' => $categories,
        ]);
    }
}
