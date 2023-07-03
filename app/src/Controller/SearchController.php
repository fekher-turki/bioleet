<?php

namespace App\Controller;

use App\Entity\Profile;
use App\Entity\Team;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SearchController extends AbstractController
{
    #[Route('/search', name: 'ajax_search', methods: ['GET'])]
    public function searchAction(
        Request $request,
        EntityManagerInterface $manager
    ) {
        $requestString = $request->get('q');

        $profiles =  $manager->getRepository(Profile::class)->findEntitiesByString($requestString);

        $teams =  $manager->getRepository(Team::class)->findEntitiesByString($requestString);

        if (!$profiles && !$teams) {
            $result['error'] = "Sorry, nothing Found.";
        } else {
            if ($profiles) {

                $result['profiles'] = $this->getRealProfiles($profiles);
            }
            if ($teams) {
                $result['teams'] = $this->getRealTeams($teams);
            }
        }

        return new Response(json_encode($result));
    }

    public function getRealProfiles($profiles)
    {

        foreach ($profiles as $profile) {
            $realProfiles[]=[
                "id" => $profile->getId(),
                "ingameName" => $profile->getIngameName(),
                "game" => [
                    "name" => $profile->getGame()->getName(),
                    "code" => $profile->getGame()->getCode()
                ],
                "user" => [
                    "avatar" => $profile->getUser()->getAvatar(),
                    "country" => $profile->getUser()->getCountry()
                ]
            ];
        }

        return $realProfiles;
    }

    public function getRealTeams($teams)
    {
        foreach ($teams as $team) {
            $realTeams[]=[
                "id" => $team->getId(),
                "teamName" => $team->getTeamName(),
                "teamUrl" => $team->getTeamUrl(),
                "game" => [
                    "name" => $team->getGame()->getName(),
                    "code" => $team->getGame()->getCode()
                ],
                "logo" => $team->getLogo(),
                "country" => $team->getCountry()
            ];
        }

        return $realTeams;
    }
}
