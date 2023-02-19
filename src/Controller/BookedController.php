<?php

namespace App\Controller;

use App\Entity\Allergy;
use App\Entity\Booking;
use App\Entity\Schedule;
use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BookedController extends AbstractController
{
    #[Route('/booked', name: 'app_booked')]
    public function index(Request $request, ManagerRegistry $managerRegistry): Response
    {
        $em = $managerRegistry->getManager();

        $booking = new Booking();
        $form_values = $request->get('booking_form');
        $cutleryNumber = $form_values["cutleryNumber"];
        $name = $form_values["name"];
        $date = $form_values["date"];
        $date = date_create_from_format("Y-m-d", $date);
        $time = $form_values["time"];
        $time = date_create_from_format("H:i", $time);
        $booking->setDate($date);
        $booking->setTime($time);
        $booking->setCutleryNumber($cutleryNumber);
        $booking->setName($name);

        $securityUser = $this->getUser();
        if ($securityUser != null) {
            $user = $em->getRepository(User::class)->findOneBy(['email' => $securityUser->getUserIdentifier()]);
            $booking->addUser($user);
            $userAllergies = $user->getAllergies();
            foreach ($userAllergies as $allergy) {
                $booking->addAllergy($allergy);
            }
        }
        $allergyEntityArray = [];
        $formAllergies = null;
        if (array_key_exists('allergies', $form_values)) {
            $formAllergies = $form_values['allergies'];
        }
        if ($formAllergies !== null) {
            foreach ($formAllergies as $allergy) {
                $allergyEntity = $em->getRepository(Allergy::class)->findOneBy(['id' => $allergy]);
                $allergyEntityArray[] = $allergyEntity;
                $booking->addAllergy($allergyEntity);
            }
        }

        $em->persist($booking);
        $em->flush();

        $em = $managerRegistry->getManager();
        $days = $em->getRepository(Schedule::class)->findAll();
        return $this->render('booked/index.html.twig', [
            'days' => $days,
            'booking_name' => $name,
            'booking_date' => $date->format("Y-m-d"),
            'booking_time' => $time->format('H:i'),
            'booking_allergies' => $allergyEntityArray,
        ]);
    }
}
