<?php

namespace App\Controller;

use App\Entity\Formula;
use App\Entity\Menu;
use App\Entity\Schedule;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MenusController extends AbstractController
{
    #[Route('/menus', name: 'app_menus')]
    public function index(ManagerRegistry $managerRegistry): Response
    {
        $em = $managerRegistry->getManager();
        $menus = $em->getRepository(Menu::class)->findAll();
        $days = $em->getRepository(Schedule::class)->findAll();
        return $this->render('menus/index.html.twig', [
            'days' => $days,
            'menus' => $menus,
        ]);
    }
}
