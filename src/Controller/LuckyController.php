<?php

namespace App\Controller;

use PHPUnit\Exception;
use Random\BrokenRandomEngineError;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LuckyController extends AbstractController
{
    /**
     * Retourne une nombre aléatoire entre 0 et 100
     *
     * @return Response
     * @throws \Exception
     */
    #[Route('/lucky/number', name: 'app_lucky_number')]
    public function number(): Response
    {
        $number = random_int(0, 100);

        return $this->render('lucky/index.html.twig', [
            'number' => $number,
        ]);
    }
}
