<?php

namespace App\Controller\Admin;

use App\Entity\Allergy;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class AllergyCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Allergy::class;
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
