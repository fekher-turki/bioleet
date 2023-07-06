<?php

namespace App\Controller;

use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PremiumController extends AbstractController
{
    #[IsGranted('ROLE_USER')]
    #[Route('/premium', name: 'premium.index')]
    public function index(): Response
    {
        $currentUser = $this->getUser();
        $isPremium = $currentUser->isPremium();

        return $this->render('pages/premium/index.html.twig', [
            'isPremium' => $isPremium,
        ]);
    }
}
