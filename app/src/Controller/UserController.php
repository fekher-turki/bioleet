<?php

namespace App\Controller;

use App\Form\AvatarType;
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
            return $this->redirectToRoute('user.edit');
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
            return $this->redirectToRoute('user.edit');
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

                return $this->redirectToRoute('user.edit');
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
            // dd($socialMedia);
            $manager->persist($socialMedia);
            $manager->flush();
            $this->addFlash(
                'success',
                'Your Social Media has been successfully updated'
            );
            return $this->redirectToRoute('user.edit');
        }

        return $this->render('pages/user/edit.html.twig', [
            'user' => $this->getUser(),
            'avatarForm' => $avatarForm->createView(),
            'form' => $form->createView(),
            'passwordForm' => $passwordForm->createView(),
            'socialMediaForm' => $socialMediaForm->createView(),
        ]);
    }

    #[Route('/account/remove/', 'user.delete', methods: ['GET'])]
    public function delete(EntityManagerInterface $manager, TokenStorageInterface $tokenStorage): Response
    {
        $user = $this->getUser();
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
