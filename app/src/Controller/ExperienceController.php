<?php

namespace App\Controller;

use App\Entity\Experience;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ExperienceController extends AbstractController
{
    // #[Route('/experience', name: 'app_experience')]
    // public function index(): Response
    // {
    //     return $this->render('experience/index.html.twig', [
    //         'controller_name' => 'ExperienceController',
    //     ]);
    // }

    #[Security("is_granted('ROLE_USER')")]
    #[Route('/account/profile/experience/{id}', name: 'experience.delete', methods: ['GET'])]
    public function delete(
        EntityManagerInterface $manager,
        string $id,
        Request $request
    ): Response
    {
        $experience = $manager->getRepository(Experience::class)->findOneBy(['id' => $id]);
        $manager->remove($experience);
        $manager->flush();

        $this->addFlash(
            'success',
            'An Experience has been successfully removed'
        );

        $referer = $request->headers->get('referer');
        return new RedirectResponse($referer);
    }
}
