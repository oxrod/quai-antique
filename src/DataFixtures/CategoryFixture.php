<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Persistence\ObjectManager;

class CategoryFixture extends \Doctrine\Bundle\FixturesBundle\Fixture
{

    /**
     * @inheritDoc
     */
    public function load(ObjectManager $manager)
    {
        $pizzas = new Category();
        $pizzas->setName('pizzas')
            ->setLabel('Pizzas');

        $manager->persist($pizzas);

        $burgers = new Category();
        $burgers->setName('burgers')
            ->setLabel('Burgers');

        $manager->persist($burgers);
        $manager->flush();
    }
}