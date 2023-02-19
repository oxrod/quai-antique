<?php

namespace App\Controller;

use App\Entity\Booking;
use App\Entity\Dish;
use App\Entity\Schedule;
use App\Entity\User;
use App\Form\BookingFormType;
use Doctrine\Persistence\ManagerRegistry;
use Faker\Factory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(ManagerRegistry $managerRegistry, Request $request): Response
    {
        $em = $managerRegistry->getManager();
        $userAllergies = null;
        $securityUser = $this->getUser();
        $user= null;
        if ($securityUser !== null) {
            $user = $em->getRepository(User::class)->findOneBy(['email' => $securityUser->getUserIdentifier()]);
            $userAllergies = $user?->getAllergies();
        }


        // ONLY FOR DEBUG PURPOSES
        $faker = Factory::create();
        $testFakeImage = $faker->imageUrl();

        $days = $em->getRepository(Schedule::class)->findAll();

        $booking = new Booking();
        $booking->setDate(new \DateTime());
        $booking_form = $this->createForm(BookingFormType::class);
        $booking_form->get('allergies')->setData([]);
        $booking_form->handleRequest($request);

        $featuredDishes = $em->getRepository(Dish::class)->findBy(['isFeatured' => true]);

        return $this->render('home/index.html.twig', [
            'userAllergies' => $userAllergies,
            'booking_form' => $booking_form->createView(),
            'featuredDishes' => $featuredDishes,
            "days" => $days
        ]);
    }

    private function getLunchSchedule(Schedule $schedule): string
    {
        $timeSpanString = "";

        $lunchStartTime = $schedule->getLunchStartTime();
        if ($lunchStartTime != null) {
            $lunchStopTime = $schedule->getLunchStopTime();
            $timeSpanString .= $lunchStartTime->format("H:i");
            $timeSpanString .= "-";
            $timeSpanString .= $lunchStopTime->format("H:i");
            return $timeSpanString;
        } else {
            return "";
        }
    }

    private function getDinerSchedule(Schedule $schedule): string
    {
        $timeSpanString = "";

        $dinerStartTime = $schedule->getDinerStartTime();
        if ($dinerStartTime != null) {
            $dinerStopTime = $schedule->getDinerStopTime();
            $timeSpanString .= $dinerStartTime->format("H:i");
            $timeSpanString .= "-";
            $timeSpanString .= $dinerStopTime->format("H:i");
            return $timeSpanString;
        } else {
            return "";
        }
    }

    private function getFrenchDayFromDate(string $day): null|string
    {
        return match ($day) {
            "Mon" => 'Lundi',
            default => null,
        };
    }
}