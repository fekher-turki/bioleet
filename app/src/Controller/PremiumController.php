<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PremiumController extends AbstractController
{
    #[Security("is_granted('ROLE_USER')")]
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
