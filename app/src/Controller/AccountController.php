<?php

namespace App\Controller;

use App\Entity\Profile;
use App\Entity\SocialMedia;
use App\Entity\Team;
use App\Form\CreateProfileType;
use App\Form\CreateTeamType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\AsciiSlugger;

class AccountController extends AbstractController
{
    #[IsGranted('ROLE_USER')]
    #[Route("/account", name: "account.index")]
    public function redirectToDashboard(): RedirectResponse
    {
        return $this->redirectToRoute('account.dashboard');
    }

    #[IsGranted('ROLE_USER')]
    #[Route('/account/dashboard', name: 'account.dashboard', methods: ['GET', 'POST'])]
    public function dashboard(Request $request, EntityManagerInterface $manager): Response
    {
        $currentUser = $this->getUser();
        $isPremium = $currentUser->isPremium();
        $profiles = $currentUser->getProfiles();
        if (!$currentUser->isPremium()) {
            $profiles = [$profiles[0]];
        }
        $hasProfiles = $currentUser->getProfiles()->count() > 0;
        
        $ownedTeams = $currentUser->getTeams();
        $joinedTeams = $manager->getRepository(Team::class)->getTeamsNotOwnedByUser($currentUser);
        if (!$currentUser->isPremium()) {
            $ownedTeams = [$ownedTeams[0]];
            $teams = array_merge($ownedTeams, $joinedTeams);
        }else{
            $teams = array_merge($ownedTeams->toArray(), $joinedTeams);
        }

        
        
        
        $hasTeams = !empty($teams);

        // new Profile
        $profile = new Profile();
        $profileForm = $this->createForm(CreateProfileType::class, $profile);
        $profileForm->handleRequest($request);
        if ($profileForm->isSubmitted() && $profileForm->isValid()) {
            $profile = $profileForm->getData();
            $profile->setUser($currentUser);
            $profile->setInGameName($currentUser->getNickname() . strtoupper($profile->getGame()->getCode()));
            $manager->persist($profile);
            $manager->flush();

            $this->addFlash(
                'success',
                'Your Profile has been successfully created'
            );

            return $this->redirectToRoute('account.dashboard');
        }

        // new Team
        $team = new Team();
        $teamForm = $this->createForm(CreateTeamType::class, $team);
        $teamForm->handleRequest($request);
        if ($teamForm->isSubmitted() && $teamForm->isValid()) {
            $team = $teamForm->getData();
            $team->setOwner($currentUser);
            $slugger = new AsciiSlugger();
            $team->setTeamUrl($slugger->slug($teamForm->get('teamName')->getData(), '_'));
            $manager->persist($team);
            $manager->flush();

            $this->addFlash(
                'success',
                'Your Team has been successfully created'
            );

            return $this->redirectToRoute('account.dashboard');
        }


        return $this->render('pages/account/dashboard.html.twig', [
            'user' => $currentUser,
            'isPremium' => $isPremium,
            'profiles' => $profiles,
            'hasProfiles' => $hasProfiles,
            'profileForm' => $profileForm->createView(),
            'teams' => $teams,
            'hasTeams' => $hasTeams,
            'teamForm' => $teamForm->createView()
        ]);
    }
}
