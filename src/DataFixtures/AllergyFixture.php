<?php

namespace App\DataFixtures;

use App\Entity\Allergy;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AllergyFixture extends Fixture
{

    /**
     * @inheritDoc
     */
    public function load(ObjectManager $manager)
    {
        $allergiesSample = ['Arachides', 'Mollusques', 'Gluten', 'Lactose'];

        foreach ($allergiesSample as $allergy) {
            $allergyEntity = new Allergy();
            $allergyEntity->setName($allergy);
            $manager->persist($allergyEntity);
        }

        $manager->flush();
    }
}