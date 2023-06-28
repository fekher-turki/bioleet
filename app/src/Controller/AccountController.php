<?php

namespace App\Controller;

use App\Entity\Profile;
use App\Form\CreateProfileType;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccountController extends AbstractController
{
    #[Security("is_granted('ROLE_USER')")]
    #[Route("/account", name: "account.index")]
    public function redirectToDashboard(): RedirectResponse
    {
        return $this->redirectToRoute('account.dashboard');
    }

    #[Security("is_granted('ROLE_USER')")]
    #[Route('/account/dashboard', name: 'account.dashboard', methods: ['GET', 'POST'])]
    public function dashboard(Request $request, EntityManagerInterface $manager): Response
    {
        $currentUser = $this->getUser();
        $profiles = $currentUser->getProfiles();
        $isPremium = $currentUser->isPremium();
        $hasProfiles = $currentUser->getProfiles()->count() > 0;

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


        return $this->render('pages/account/dashboard.html.twig', [
            'user' => $currentUser,
            'profiles' => $profiles,
            'isPremium' => $isPremium,
            'hasProfiles' => $hasProfiles,
            'profileForm' => $profileForm
        ]);
    }
}
