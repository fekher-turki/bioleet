<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\SignUpType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    #[Route('/login', name: 'security.login', methods: ['GET', 'POST'])]
    public function index(AuthenticationUtils $authenticationUtils): Response
    {
        return $this->render('pages/security/login.html.twig', [
            'last_username' => $authenticationUtils->getLastUsername(),
            'error' => $authenticationUtils->getLastAuthenticationError()
        ]);
    }

    #[Route('/logout', name: 'security.logout')]
    public function logout(): never
    {
        // controller can be blank: it will never be called!
        // throw new \Exception('Don\'t forget to activate logout in security.yaml');
    }

    #[Route('/signup', 'security.signup', methods: ['GET', 'POST'])]
    public function signup(Request $request, EntityManagerInterface $manager, MailerInterface $mailer, TokenGeneratorInterface $tokenGenerator): Response
    {
        $user = new User();
        $user->setRoles(['ROLE_USER']);
        $form = $this->createForm(SignUpType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();
            // Custom uniqueness validation for 'username'
            $username = $user->getUsername();
            $existingUser = $manager->getRepository(User::class)->findOneBy(['username' => $username]);

            if ($existingUser) {
                $form->get('username')->addError(new FormError('This username is already taken.'));
            } else {
                $user->setNickname($user->getUsername());
                $user->setEmailVerified(false);

                $verificationToken = $tokenGenerator->generateToken();
                $user->setVerificationToken($verificationToken);

                $manager->persist($user);
                $manager->flush();

                $email = (new TemplatedEmail())
                    ->from(new Address('BioLeetCom@hotmail.com', 'BioLeet Mail Bot'))
                    ->to($user->getEmail())
                    ->subject('Email Verification')
                    ->text('Click the link to verify your email: '.$this->generateUrl('security.verify_email', ['token' => $verificationToken], UrlGeneratorInterface::ABSOLUTE_URL));
                
                $mailer->send($email);
                
                $this->addFlash(
                    'success',
                    'Your account has been successfully created. Please check your email to verify your account.'
                );

                return $this->redirectToRoute('security.login');
            }
        }

        return $this->render('pages/security/signup.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/verify-email/{token}', name: 'security.verify_email', methods: ['GET'])]
    public function verifyEmail(string $token, EntityManagerInterface $manager): Response
    {
        $user = $manager->getRepository(User::class)->findOneBy(['verificationToken' => $token]);
        $user->setEmailVerified(true);
        $manager->persist($user);
        $manager->flush();

        $this->addFlash(
            'success',
            'Your email has been successfully verified. You can now log in.'
        );

        return $this->redirectToRoute('security.login');
    }
}
