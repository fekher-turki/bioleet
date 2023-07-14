<?php

namespace App\Controller\Admin;

use App\Entity\GameRole;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_ADMIN')]
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
            ->setPageTitle("index", "Game Roles | BioLeet.com")
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
