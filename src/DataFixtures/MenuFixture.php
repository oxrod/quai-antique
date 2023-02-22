<?php

namespace App\DataFixtures;

use App\Entity\Formula;
use App\Entity\Menu;
use Doctrine\Persistence\ObjectManager;

class MenuFixture extends \Doctrine\Bundle\FixturesBundle\Fixture
{

    /**
     * @inheritDoc
     */
    public function load(ObjectManager $manager)
    {
        $lunchFormula = $manager->getRepository(Formula::class)->findOneBy(['title' => 'Formule midi']);
        $dinerFormula = $manager->getRepository(Formula::class)->findOneBy(['title' => 'Formule soir']);

        $menu1 = new Menu();
        $menu1->setTitle('Menu du marché')
            ->addFormula($lunchFormula)
            ->addFormula($dinerFormula);

        $manager->persist($menu1);

        $menu2 = new Menu();
        $menu2->setTitle('Menu Brunch')
            ->addFormula($lunchFormula);

        $manager->persist($menu2);

        $manager->flush();
    }

    public function getDependencies(): array {
        return [
            FormulaFixture::class,
        ];
    }
}