<?php

namespace App\DataFixtures;

use App\Entity\Formula;
use Doctrine\Persistence\ObjectManager;

class FormulaFixture extends \Doctrine\Bundle\FixturesBundle\Fixture
{

    /**
     * @inheritDoc
     */
    public function load(ObjectManager $manager)
    {
        $basicLunchFormula = new Formula();
        $basicLunchFormula->setTitle('Formule midi')
            ->setDescription('Entrée + Plat + Dessert et café')
            ->setWhenText('(midi uniquement en semaine)')
            ->setPrice(24);

        $manager->persist($basicLunchFormula);

        $basicDinerFormula = new Formula();
        $basicDinerFormula->setTitle('Formule Soir')
            ->setDescription('Entrée + Plat ou Plat + Dessert')
            ->setWhenText('(Du jeudi au dimanche soir)')
            ->setPrice(22);

        $manager->persist($basicDinerFormula);

        $manager->flush();
    }
}