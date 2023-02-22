<?php

namespace App\Controller\Admin;

use App\Entity\Dish;
use App\Field\VichImageField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Form\Type\FileUploadType;
use Vich\UploaderBundle\Form\Type\VichImageType;

class DishCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Dish::class;
    }


    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('title');
        yield TextField::new('description');
        yield TextField::new('price');
        yield AssociationField::new('category');
        yield VichImageField::new('image')->hideOnForm();
        yield VichImageField::new('imageFile')->onlyOnForms();
        yield BooleanField::new('isFeatured');

    }

}
