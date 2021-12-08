<?php

namespace App\Controller\Admin;

use App\Entity\Vilain;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class VilainCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Vilain::class;
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
