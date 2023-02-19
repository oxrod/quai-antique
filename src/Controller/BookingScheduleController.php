<?php

namespace App\Controller;

use App\Entity\Booking;
use App\Entity\Restaurant;
use App\Entity\Schedule;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BookingScheduleController extends AbstractController
{
    private ManagerRegistry $managerRegistry;

    public function __construct(ManagerRegistry $managerRegistry)
    {
        $this->managerRegistry = $managerRegistry;
    }

    #[Route('/booking/time/{day}/remaining-capacity', name: 'app_booking_schedule')]
    public function index(string $day): Response
    {
        $em = $this->managerRegistry->getManager();
        $dayDate = date_create_from_format('Y-m-d', $day);
        $day = $dayDate->format('D');
        $day = $this->getFrenchDayFromDate($day);
        $maxCapacity = $em->getRepository(Restaurant::class)->findOneBy(['name' => 'quai-antique'])->getMaxGuestCapacity();
        $dayLunchStopTime = $em->getRepository(Schedule::class)->findOneBy(['day' => $day]);
        $dayLunchStopTimeString = "";

        $lunchCapacity = 0;
        $dinerCapacity = 0;
        if ($dayLunchStopTime !== null) {
            $dayLunchStopTimeString = $dayLunchStopTime->getLunchStopTime();
            if ($dayLunchStopTimeString !== null) {
                $dayLunchStopTimeString = $dayLunchStopTimeString->format('H:i');
                $lunchCapacity = $maxCapacity;
            }
        } else {
            $lunchCapacity = -1;
        }
        $dayDiner = $em->getRepository(Schedule::class)->findOneBy(['day' => $day]);
        if($dayDiner !== null) {
            $dayDinerStopTime = $dayDiner->getDinerStopTime();
            if ($dayDinerStopTime !== null) {
                $dinerCapacity = $maxCapacity;
            }
        } else {
            $dinerCapacity = -1;
        }

        $bookings = $em->getRepository(Booking::class)->findBy(['date' => $dayDate]);

        foreach ($bookings as $booking) {
            if ($booking->getTime()->format('H:i') < $dayLunchStopTimeString) {
                $lunchCapacity -= $booking->getCutleryNumber();
            } else {
                $dinerCapacity -= $booking->getCutleryNumber();
            }
        }

        return new JsonResponse(['data' => [$lunchCapacity, $dinerCapacity]]);
    }

    private function getFrenchDayFromDate(string $day): null|string
    {
        return match ($day) {
            "Mon" => 'Lundi',
            "Tue" => 'Mardi',
            "Wed" => 'Mercredi',
            "Thu" => 'Jeudi',
            "Fri" => 'Vendredi',
            "Sat" => 'Samedi',
            "Sun" => 'Dimanche',
            default => null,
        };
    }
}
