<?php

namespace App\Controller;

use App\Entity\Game;
use App\Entity\Profile;
use App\Form\EditProfileType;
use App\Form\ExperienceType;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfileController extends AbstractController
{
    #[Route('/profile/{game}/{ingameName}', name: 'profile.index', methods: ['GET'])]
    public function index(
        EntityManagerInterface $manager,
        string $game,
        string $ingameName,
    ): Response
    {
        $currentUser = $this->getUser();
        $gameCode = $manager->getRepository(Game::class)->findOneBy(['code' => $game]);
        $profile = $manager->getRepository(Profile::class)->findOneBy(['ingameName' => $ingameName, 'game' => $gameCode]);
        if (!$profile) {
            return $this->redirectToRoute('account.index');
        }
        $user = $profile->getUser();
        $isBanned = $user->isBanned();
        $isPremium = $user->isPremium();

        return $this->render('pages/profile/index.html.twig', [
            'isPremium' => $isPremium,
            'isBanned' => $isBanned,
            'profile' => $profile,
            'team' => false,
            'user' => $user,
            'embed' => "https://www.youtube.com/embed/",
        ]);
    }

    #[Security("is_granted('ROLE_USER')")]
    #[Route('/account/profile/{game}/{ingameName}', name: 'profile.edit', methods: ['GET', 'POST'])]
    public function edit(
        Request $request,
        EntityManagerInterface $manager,
        string $ingameName,
        string $game
        ): Response
    {        
        $gameCode = $manager->getRepository(Game::class)->findOneBy(['code' => $game]);
        $profile = $manager->getRepository(Profile::class)->findOneBy(['ingameName' => $ingameName, 'game' => $gameCode]);

        if (!$profile || $profile->getUser() !== $this->getUser()) {
            return $this->redirectToRoute('account.index');
        }
        
        // $currentUser = $this->getUser();
        // $isPremium = $currentUser->isPremium();
        $experiences = $profile->getExperiences();
        $hasExperiences = $experiences->count() > 0;

        // profile form
        $profileForm = $this->createForm(EditProfileType::class, $profile);
        $profileForm->handleRequest($request);
        
        if ($profileForm->isSubmitted() && $profileForm->isValid()) {
            $profile = $profileForm->getData();
            $manager->persist($profile);
            $manager->flush();

            $this->addFlash(
                'success',
                'Your Profile has been successfully updated'
            );

            return $this->redirectToRoute('account.dashboard');
        }

        // experience form
        $experienceForm = $this->createForm(ExperienceType::class);
        $experienceForm->handleRequest($request);
        
        if ($experienceForm->isSubmitted() && $experienceForm->isValid()) {
            $experience = $experienceForm->getData();
            $experience->setProfile($profile);
            $manager->persist($experience);
            $manager->flush();

            $this->addFlash(
                'success',
                'Your Experiences has been successfully updated'
            );

            return $this->redirectToRoute('profile.edit', [
                'game' => $game,
                'ingameName' => $ingameName
            ]);
        }

        return $this->render('pages/profile/edit.html.twig', [
            'profileForm' => $profileForm->createView(),
            'experienceForm' => $experienceForm->createView(),
            'experiences' => $experiences,
            'hasExperiences' => $hasExperiences
        ]);
    }

    #[Security("is_granted('ROLE_USER')")]
    #[Route('/account/profile/{game}/{ingameName}/delete', name: 'profile.delete', methods: ['GET'])]
    public function delete(
        EntityManagerInterface $manager,
        string $ingameName,
        string $game
    ): Response
    {
        $gameCode = $manager->getRepository(Game::class)->findOneBy(['code' => $game]);
        $profile = $manager->getRepository(Profile::class)->findOneBy(['ingameName' => $ingameName, 'game' => $gameCode]);

        if (!$profile || $profile->getUser() !== $this->getUser()) {
            return $this->redirectToRoute('account.dashboard');
        }

        $manager->remove($profile);
        $manager->flush();

        $this->addFlash(
            'success',
            'Your Profile has been successfully removed'
        );

        return $this->redirectToRoute('account.dashboard');
    }
}
