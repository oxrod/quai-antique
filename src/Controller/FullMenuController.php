<?php

namespace App\Controller;

use App\Entity\Dish;
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

        return $this->render('full_menu/index.html.twig', [
            'dishes' => $dishes,
        ]);
    }
}
