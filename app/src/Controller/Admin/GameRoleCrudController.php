<?php

namespace App\Controller\Admin;

use App\Entity\GameRole;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class GameRoleCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return GameRole::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInPlural('Game Roles')
            ->setEntityLabelInSingular('Game Role')
            ->setPageTitle("index", "Admin - Game Roles")
            ->setPaginatorPageSize(10)
        ;
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
