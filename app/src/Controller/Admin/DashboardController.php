<?php

namespace App\Controller\Admin;

use App\Entity\Country;
use App\Entity\Game;
use App\Entity\GameRole;
use App\Entity\Language;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        return $this->render('admin/dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('BioLeet - Admin');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Users', 'fas fa-users', User::class);
        yield MenuItem::subMenu('Games', 'fa fa-gamepad')->setSubItems([
            MenuItem::linkToCrud('Games', 'fa fa-gamepad', Game::class),
            MenuItem::linkToCrud('Game Roles', 'fa fa-chess-pawn', GameRole::class),
        ]);
    }
}
