<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInPlural('Users')
            ->setEntityLabelInSingular('User')
            ->setPageTitle("index", "Admin - Users")
            ->setPaginatorPageSize(10)
        ;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')
                ->hideOnForm(),
            TextField::new('email'),
            TextField::new('nickname')
                ->hideOnForm(),
            ArrayField::new('roles'),
            TextField::new('username')
                ->hideOnIndex(),
            BooleanField::new('isVerified'),
            DateTimeField::new('premiumStart')
                ->hideOnIndex(),
            DateTimeField::new('premiumEnd'),
            DateTimeField::new('banStart')
                ->hideOnIndex(),
            DateTimeField::new('banEnd'),
            TextField::new('banReason'),
            DateTimeField::new('createdAt')
                ->hideOnForm()
        ];
    }
}
