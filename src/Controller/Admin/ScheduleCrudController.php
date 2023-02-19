<?php

namespace App\Controller\Admin;

use App\Entity\Schedule;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TimeField;

class ScheduleCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Schedule::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('day', 'Jour de la semaine'),
            TimeField::new('lunchStartTime', 'Début du service du midi'),
            TimeField::new('lunchStopTime', 'FIn du service du midi'),
            TimeField::new('dinerStartTime', 'Début du service du soir'),
            TimeField::new('dinerStopTime', 'Fin du service du soir'),
        ];
    }

}
