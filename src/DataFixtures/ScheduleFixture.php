<?php

namespace App\DataFixtures;

use App\Entity\Schedule;
use Doctrine\Persistence\ObjectManager;

class ScheduleFixture extends \Doctrine\Bundle\FixturesBundle\Fixture
{

    /**
     * @inheritDoc
     */
    public function load(ObjectManager $manager)
    {
        $monday = new Schedule();
        $monday->setDay('Lundi');

        $manager->persist($monday);

        $tuesday = new Schedule();
        $tuesday->setDay('Mardi')
            ->setLunchStartTime(date_create_from_format("H:i", '12:00'))
            ->setLunchStopTime(date_create_from_format("H:i", "15:00"))
            ->setDinerStartTime(date_create_from_format("H:i", "19:00"))
            ->setDinerStopTime(date_create_from_format("H:i", "22:30"));

        $manager->persist($tuesday);

        $wednesday = new Schedule();
        $wednesday->setDay('Mercredi')
            ->setLunchStartTime(date_create_from_format("H:i", '12:15'))
            ->setLunchStopTime(date_create_from_format("H:i", "15:30"))
            ->setDinerStartTime(date_create_from_format("H:i", "19:30"))
            ->setDinerStopTime(date_create_from_format("H:i", "22:15"));

        $manager->persist($wednesday);

        $thursday = new Schedule();
        $thursday->setDay('Jeudi')
            ->setLunchStartTime(date_create_from_format("H:i", '12:30'))
            ->setLunchStopTime(date_create_from_format("H:i", "15:00"))
            ->setDinerStartTime(date_create_from_format("H:i", "19:45"))
            ->setDinerStopTime(date_create_from_format("H:i", "22:30"));

        $manager->persist($thursday);

        $friday = new Schedule();
        $friday->setDay('Vendredi')
            ->setLunchStartTime(date_create_from_format("H:i", '12:15'))
            ->setLunchStopTime(date_create_from_format("H:i", "15:00"))
            ->setDinerStartTime(date_create_from_format("H:i", "19:00"))
            ->setDinerStopTime(date_create_from_format("H:i", "22:15"));

        $manager->persist($friday);

        $saturday = new Schedule();
        $saturday->setDay('Samedi')
            ->setLunchStartTime(date_create_from_format("H:i", '12:30'))
            ->setLunchStopTime(date_create_from_format("H:i", "15:30"))
            ->setDinerStartTime(date_create_from_format("H:i", "19:00"))
            ->setDinerStopTime(date_create_from_format("H:i", "22:30"));

        $manager->persist($saturday);

        $sunday = new Schedule();
        $sunday->setDay('Dimanche')
            ->setLunchStartTime(date_create_from_format("H:i", '12:00'))
            ->setLunchStopTime(date_create_from_format("H:i", "15:30"))
            ->setDinerStartTime(date_create_from_format("H:i", "19:00"))
            ->setDinerStopTime(date_create_from_format("H:i", "22:45"));

        $manager->persist($sunday);

        $manager->flush();
    }
}