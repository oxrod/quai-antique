<?php

namespace App\DataFixtures;

use App\Entity\Dish;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class DishFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        for($i = 0; $i < 20 ; $i++) {
            $dish = new Dish();
            $dish
                ->setTitle($faker->words(3, true))
                ->setDescription($faker->sentences(2, true))
                ->setPrice($faker->numberBetween(5, 15))
                ->setCategory($faker->word);
            $manager->persist($dish);
        }
        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }
}
