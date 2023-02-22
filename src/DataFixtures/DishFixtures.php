<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Dish;
use Doctrine\Persistence\ObjectManager;

class DishFixtures extends \Doctrine\Bundle\FixturesBundle\Fixture
{

    /**
     * @inheritDoc
     */
    public function load(ObjectManager $manager)
    {
        $burgersCategory = $manager->getRepository(Category::class)->findOneBy(['name' => 'burgers']);
        $pizzasCategory = $manager->getRepository(Category::class)->findOneBy(['name' => 'pizzas']);

        $burger1 = new Dish();
        $burger1
            ->setTitle('Burger1')
            ->setDescription('Description burger1')
            ->setPrice('15.50')
            ->setCategory($burgersCategory)
            ->setImage('hamburger-g5304618c8_1920.jpg')
            ->setIsFeatured(true);

        $manager->persist($burger1);
        $manager->flush();

        $pizza1 = new Dish();
        $pizza1
            ->setTitle('Pizza1')
            ->setDescription('Description pizza1')
            ->setPrice('15.50')
            ->setCategory($pizzasCategory)
            ->setImage('pizza-g33f61f0b4_1920.jpg')
            ->setIsFeatured(true);

        $manager->persist($pizza1);
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            CategoryFixture::class,
        ];
    }
}