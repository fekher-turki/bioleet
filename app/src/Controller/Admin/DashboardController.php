<?php

namespace App\Controller\Admin;

use App\Entity\Feedback;
use App\Entity\Game;
use App\Entity\GameRole;
use App\Entity\Profile;
use App\Entity\Team;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\UserMenu;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

class DashboardController extends AbstractDashboardController
{
    private $manager;

    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }
    
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        $users = $this->manager->getRepository(User::class)->count([]);
        $profiles = $this->manager->getRepository(Profile::class)->count([]);
        $teams = $this->manager->getRepository(Team::class)->count([]);
        $premiumUsers = $this->manager->getRepository(User::class)->createQueryBuilder('u')
            ->select('COUNT(u.id)')
            ->where('u.premiumEnd >= :today')
            ->setParameter('today', new \DateTime('today'))
            ->getQuery()
            ->getSingleScalarResult();
        
        $countries = $this->manager->getRepository(User::class)->createQueryBuilder('u')
            ->select('COUNT(u) as count, u.country as code')
            ->groupBy('u.country')
            ->getQuery()
            ->getArrayResult();
        
        $userGrowth = $this->manager->getRepository(User::class)->getUserCountsByMonth();
        
        return $this->render('admin/dashboard.html.twig', [
            'users' => $users,
            'profiles' => $profiles,
            'teams' => $teams,
            'premiumUsers' => $premiumUsers,
            'countries' => $countries,
            'userGrowth' => $userGrowth
        ]);
    }

    public function configureUserMenu(UserInterface $user): UserMenu
    {
        if ($user->getAvatar() == "default-avatar.png") {
            $userAvatar = "images/default/default-avatar.png";
        } else {
            $userAvatar = "images/users/".$user->getAvatar();
        }
        // Usually it's better to call the parent method because that gives you a
        // user menu with some menu items already created ("sign out", "exit impersonation", etc.)
        // if you prefer to create the user menu from scratch, use: return UserMenu::new()->...
        return parent::configureUserMenu($user)
            // use the given $user object to get the user name
            ->setName($user->getUsername())
            // use this method if you don't want to display the name of the user
            ->displayUserName(true)

            // you can return an URL with the avatar image
            // ->setAvatarUrl('https://www.pngmart.com/files/21/Admin-Profile-PNG-Image.png')
            ->setAvatarUrl($userAvatar)
            // use this method if you don't want to display the user image
            ->displayUserAvatar(true)
            // you can also pass an email address to use gravatar's service
            // ->setGravatarEmail($user->getEmail())

            // you can use any type of menu item, except submenus
            ->addMenuItems([
                MenuItem::linkToRoute('User Dashboard', 'fa fa-gauge', 'account.index'),
                MenuItem::linkToRoute('Settings', 'fa fa-user-cog', 'user.edit'),
                // MenuItem::section(),
                // MenuItem::linkToLogout('Logout', 'fa fa-sign-out'),
            ]);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('BioLeet - Admin');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-gauge');
        yield MenuItem::linkToCrud('Users', 'fas fa-user', User::class);
        yield MenuItem::linkToCrud('Profiles', 'fas fa-id-badge', Profile::class);
        yield MenuItem::linkToCrud('Teams', 'fas fa-users', Team::class);
        yield MenuItem::subMenu('Games', 'fa fa-gamepad')->setSubItems([
            MenuItem::linkToCrud('Games', 'fa fa-gamepad', Game::class),
            MenuItem::linkToCrud('Game Roles', 'fa fa-chess-pawn', GameRole::class),
        ]);
        yield MenuItem::linkToCrud('Feedback', 'fas fa-comment', Feedback::class);
        yield MenuItem::linkToRoute('Back to Home', 'fas fa-rotate-right', 'home.index');
    }
}
