<?php

namespace App\Controller\Admin;

use App\Entity\Allergy;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class AllergyCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Allergy::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name')
        ];
    }
}
