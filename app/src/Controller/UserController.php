<?php

namespace App\Controller;

use App\Form\AvatarType;
use App\Form\SetupType;
use App\Form\SocialMediaType;
use App\Form\UserPasswordType;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class UserController extends AbstractController
{
    #[Security("is_granted('ROLE_USER')")]
    #[Route('/account/settings', name: 'user.edit', methods: ['GET', 'POST'])]
    public function edit(
        Request $request,
        EntityManagerInterface $manager,
        UserPasswordHasherInterface $hasher,
    ): Response {
        $currentUser = $this->getUser();
        $isPremium = $currentUser->isPremium();
        $socialMedia = $currentUser->getSocialMedia();

        // avatar form
        $avatarForm = $this->createForm(AvatarType::class, $currentUser);
        $avatarForm->handleRequest($request);

        if ($avatarForm->isSubmitted() && $avatarForm->isValid()) {
            $user = $avatarForm->getData();
            $manager->persist($user);
            $manager->flush();
            $this->addFlash(
                'success',
                'Your Avatar has been successfully updated'
            );
            
        } elseif ($avatarForm->isSubmitted() && !$avatarForm->isValid()) {
            $errors = $avatarForm->getErrors(true);
            if ($errors->count() > 0) {
                $errorMessage = $errors->current()->getMessage();
                $this->addFlash(
                    'warning',
                    $errorMessage
                );
            }
        }

        // user form
        $form = $this->createForm(UserType::class, $currentUser);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();
            $user->setIsFirstLogin(false);
            $manager->persist($user);
            $manager->flush();
            $this->addFlash(
                'success',
                'Your Account has been successfully updated'
            );
        } elseif ($form->isSubmitted() && !$form->isValid()) {
            $errors = $form->getErrors(true);
            if ($errors->count() > 0) {
                $errorMessage = $errors->current()->getMessage();
                $this->addFlash(
                    'warning',
                    $errorMessage
                );
            }
        }

        // password form
        $passwordForm = $this->createForm(UserPasswordType::class);
        $passwordForm->handleRequest($request);

        if ($passwordForm->isSubmitted() && $passwordForm->isValid()) {
            if ($hasher->isPasswordValid($currentUser, $passwordForm->get('plainPassword')->getData())) {
                $currentUser->setUpdatedAt(new \DateTimeImmutable());
                $currentUser->setPlainPassword(
                    $passwordForm->get('newPassword')->getData()
                );
                $manager->persist($currentUser);
                $manager->flush();
                $this->addFlash(
                    'success',
                    'Your Password has been successfully updated'
                );

            } else {
                $this->addFlash(
                    'warning',
                    'Your Password is not correct.'
                );
            }
        } elseif ($passwordForm->isSubmitted() && !$passwordForm->isValid()) {
            $errors = $passwordForm->getErrors(true);
            if ($errors->count() > 0) {
                $errorMessage = $errors->current()->getMessage();
                $this->addFlash(
                    'warning',
                    $errorMessage
                );
            }
        }

        // social media form
        $socialMediaForm = $this->createForm(SocialMediaType::class, $socialMedia);
        $socialMediaForm->handleRequest($request);

        if ($socialMediaForm->isSubmitted() && $socialMediaForm->isValid()) {
            $socialMedia = $socialMediaForm->getData();
            $socialMedia->setUser($this->getUser());
            $manager->persist($socialMedia);
            $manager->flush();
            $this->addFlash(
                'success',
                'Your Social Media has been successfully updated'
            );
        }

        return $this->render('pages/user/edit.html.twig', [
            'user' => $this->getUser(),
            'isPremium' => $isPremium,
            'avatarForm' => $avatarForm->createView(),
            'form' => $form->createView(),
            'passwordForm' => $passwordForm->createView(),
            'socialMediaForm' => $socialMediaForm->createView(),
        ]);
    }

    #[Security("is_granted('ROLE_USER')")]
    #[Route('/account/setup', name: 'user.setup', methods: ['GET', 'POST'])]
    public function setup(
        Request $request,
        EntityManagerInterface $manager,
    ): Response {
        $currentUser = $this->getUser();
        $isPremium = $currentUser->isPremium();
        $setup = $currentUser->getSetup();

        // social media form
        $setupForm = $this->createForm(SetupType::class, $setup);
        $setupForm->handleRequest($request);
        
        if ($setupForm->isSubmitted() && $setupForm->isValid()) {
            $setup = $setupForm->getData();
            $setup->setUser($this->getUser());
            $manager->persist($setup);
            $manager->flush();
            $this->addFlash(
                'success',
                'Your Setup has been successfully updated'
            );
        }

        return $this->render('pages/user/setup.html.twig', [
            'user' => $this->getUser(),
            'isPremium' => $isPremium,
            'setupForm' => $setupForm->createView()
        ]);
    }

    #[Route('/account/remove/', 'user.delete', methods: ['GET'])]
    public function delete(EntityManagerInterface $manager, TokenStorageInterface $tokenStorage): Response
    {
        $user = $this->getUser();
        $teams = $user->getTeams();

        foreach ($teams as $team) {
            $profiles = $team->getPlayers();

            foreach ($profiles as $profile) {
                $profile->setTeam(null);
            }
        }

        $manager->remove($user);
        $manager->flush();

        $tokenStorage->setToken(null);

        $this->addFlash(
            'success',
            'Your Account has been successfully removed'
        );

        return $this->redirectToRoute('security.signup');
    }
}
