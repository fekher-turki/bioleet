<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StaticController extends AbstractController
{
    #[Route('/privacy-policy', name: 'static.privacy_policy')]
    public function privacyPolicy(): Response
    {
        return $this->render('pages/static/privacy_policy.html.twig');
    }

    #[Route('/terms-of-service', name: 'static.terms_of_service')]
    public function termsOfService(): Response
    {
        return $this->render('pages/static/terms_of_service.html.twig');
    }

    #[Route('/user-guidelines', name: 'static.user_guidelines')]
    public function userGuidelines(): Response
    {
        return $this->render('pages/static/user_guidelines.html.twig');
    }
}
