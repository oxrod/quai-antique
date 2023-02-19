<?php

namespace App\Controller;

use App\Entity\Schedule;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class LoginController extends AbstractController
{
    #[Route('/login', name: 'app_login')]
    public function index(AuthenticationUtils $authenticationUtils, ManagerRegistry $managerRegistry): Response
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        $em = $managerRegistry->getManager();
        $days = $em->getRepository(Schedule::class)->findAll();

        return $this->render('login/index.html.twig', [
            'days' => $days,
            'last_username' => $lastUsername,
            'error' => $error
        ]);
    }
}
