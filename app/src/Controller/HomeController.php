<?php

namespace App\Controller;

use App\Form\ContactType;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home.index')]
    public function index(
        MailerInterface $mailer,
        Request $request,
    ): Response {
        $currentUser = $this->getUser();
        $contactForm = $this->createForm(ContactType::class);
        $contactForm->handleRequest($request);

        if ($contactForm->isSubmitted() && $contactForm->isValid()) {
            $contact = $contactForm->getData();

            $email = (new TemplatedEmail())
                ->from(new Address('BioLeetCom@hotmail.com', 'BioLeet Mail Bot'))
                ->to('BioLeetCom@hotmail.com')
                ->subject($contact['subject'])
                ->htmlTemplate('partials/contact_email.html.twig')
                ->context([
                'contact' => $contact,
            ]);

            $mailer->send($email);

            $this->addFlash(
                'email-success',
                'Your Request has been successfully sent'
            );

            return $this->redirectToRoute('home.index', ['_fragment' => 'contact']);
        }

        return $this->render('pages/home/index.html.twig', [
            'contactForm' => $contactForm->createView(),
        ]);
    }
}
