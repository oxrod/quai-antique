<?php

namespace App\Controller;

use App\Entity\Schedule;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class BookingTimeController extends AbstractController
{
    /**
     * @throws \Exception
     */
    #[Route('/booking/time/{day}', name: 'app_booking_time')]
    public function index(string $day, ManagerRegistry $managerRegistry): JsonResponse
    {
        $finalData = [];
        $finalData[0] = 'Aucune information pour cette date';
        $finalData[1] = 'Aucune information pour cette date';
        $em = $managerRegistry->getManager();

        $todayString = $this->getFrenchDay(new \DateTime($day));
        $todaySchedule = $em->getRepository(Schedule::class)->findOneBy(['day' => $todayString]);

        if($todaySchedule !== null) {
            if ($todaySchedule->getLunchStartTime() == null) {
                $finalData[0] = "Pas de créneaux pour cette date";
            } else {
                $lunchSlots = $this->getTimeSlotsFromSchedules($todaySchedule->getLunchStartTime(), $todaySchedule->getLunchStopTime());
                $finalData[0] = $lunchSlots;
            }
            if($todaySchedule->getDinerStartTime() == null) {
                $finalData[1] = "Pas de créneaux pour cette date";
            } else {
                $dinerSlots = $this->getTimeSlotsFromSchedules($todaySchedule->getDinerStartTime(), $todaySchedule->getDinerStopTime());
                $finalData[1] = $dinerSlots;
            }
        }

        return new JsonResponse(['data' => $finalData]);
    }

    private function getTimeSlotsFromSchedules(\DateTimeInterface $startTime, \DateTimeInterface $stopTime): array
    {
        // Final Array + index
        $timeSlots[0] = $startTime->format('H:i');
        $index = 1;

        // Time limits
        $hoursLimit = intval($stopTime->format('H')) - 2;
        $minutesLimit = intval($stopTime->format('i'));

        // Counters
        $hours = intval($startTime->format('H'));
        $minutes = intval($startTime->format('i'));

        while (!($hours > $hoursLimit && $minutes > $minutesLimit)) {
            $minutes += 15;
            if ($minutes >= 60) {
                if (($hours + 1) > $hoursLimit) {
                    return $timeSlots;
                }
                $hours += 1;
                $minutes -= 60;
            }
            $tempString = "";
            $tempString .= $hours;
            $tempString .= ':';
            if ($minutes == 0) {
                $tempString .= "00";
            } else {
                if ($minutes < 10) {
                    $tempString .= "0";
                }
                $tempString .= $minutes;
            }
            $timeSlots[$index] = $tempString;
            $index += 1;
        }
        return $timeSlots;
    }

    private function getFrenchDay(\DateTime $dateTime): string
    {
        return $this->getFrenchDayFromDate($dateTime->format("D"));
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
