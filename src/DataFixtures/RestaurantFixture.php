<?php

namespace App\DataFixtures;

use App\Entity\Restaurant;
use Doctrine\Persistence\ObjectManager;

class RestaurantFixture extends \Doctrine\Bundle\FixturesBundle\Fixture
{

    /**
     * @inheritDoc
     */
    public function load(ObjectManager $manager)
    {
        $quaiAntique = new Restaurant();
        $quaiAntique ->setName('quai-antique')
            ->setMaxGuestCapacity(60)
            ->setRemainingGuestCapacity(60);

        $manager->persist($quaiAntique);
        $manager->flush();
    }
}