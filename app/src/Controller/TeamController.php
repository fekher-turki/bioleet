<?php

namespace App\Controller;

use App\Entity\Game;
use App\Entity\Profile;
use App\Entity\Team;
use App\Form\EditTeamType;
use App\Form\InviteTeamType;
use App\Form\LogoType;
use App\Form\SocialMediaType;
use App\Form\TeamSearchType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Intl\Countries;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\AsciiSlugger;

class TeamController extends AbstractController
{

    #[Route('/team/{game}/{teamUrl}', name: 'team.index', methods: ['GET'])]
    public function index(
        EntityManagerInterface $manager,
        string $game,
        string $teamUrl,
    ): Response
    {
        $gameCode = $manager->getRepository(Game::class)->findOneBy(['code' => $game]);
        $team = $manager->getRepository(Team::class)->findOneBy(['teamUrl' => $teamUrl, 'game' => $gameCode]);
        $user = $team->getOwner();
        $isBanned = $user->isBanned();
        $isPremium = $user->isPremium();
        $isPremiumTeam = $team->getOwner()->isPremium();
        if ($team->getOverview())
        {
            $overview = $team->getOverview();
        } else {
            $countryName = Countries::getName($team->getCountry());
            $overview = $team->getTeamName()." is a ".$team->getGame()." team from ".$countryName;
        }

        return $this->render('pages/team/index.html.twig', [
            'isPremium' => $isPremium,
            'isPremiumTeam' => $isPremiumTeam,
            'isBanned' => $isBanned,
            'team' => $team,
            'overview' => $overview,
            'user' => $user
        ]);
    }

    #[Route('/teams', name: 'team.list', methods: ['GET'])]
    public function list(Request $request, EntityManagerInterface $manager): Response
    {
        if ($this->getUser()) {
            $isPremium = $this->getUser()->isPremium();
        } else {
            $isPremium = false;
        }
        $searchForm = $this->createForm(TeamSearchType::class);
        $searchForm->handleRequest($request);
    
        if ($searchForm->isSubmitted() && $searchForm->isValid()) {
            $data = $searchForm->getData();
            $teams = $manager->getRepository(Team::class)
                ->search(
                    $data->getTeamName(),
                    $data->getCountry(),
                    $data->getGame()
                );
        } else {
            $teams = $manager->getRepository(Team::class)
                ->createQueryBuilder('t')
                ->leftJoin('t.owner', 'o')
                ->orderBy('CASE WHEN (o.premiumEnd >= CURRENT_DATE()) THEN 0 ELSE 1 END')
                ->addOrderBy('t.createdAt', 'DESC')
                ->setMaxResults(40)
                ->getQuery()
                ->getResult();
        }
    
        return $this->render('pages/team/list.html.twig', [
            'searchForm' => $searchForm->createView(),
            'teams' => $teams,
            'isPremium' => $isPremium,
        ]);
    }

    #[IsGranted('ROLE_USER')]
    #[Route('/account/team/edit/{game}/{teamUrl}', name: 'team.edit', methods: ['GET', 'POST'])]
    public function edit(
        Request $request,
        EntityManagerInterface $manager,
        string $teamUrl,
        string $game
        ): Response
    {
        $isPremium = $this->getUser()->isPremium();
        $gameCode = $manager->getRepository(Game::class)->findOneBy(['code' => $game]);
        $team = $manager->getRepository(Team::class)->findOneBy(['teamUrl' => $teamUrl, 'game' => $gameCode]);
        $socialMedia = $team->getSocialMedia();

        if (!$team || $team->getOwner() !== $this->getUser()) {
            return $this->redirectToRoute('account.index');
        }

        // logo form
        $logoForm = $this->createForm(LogoType::class, $team);
        $logoForm->handleRequest($request);

        if ($logoForm->isSubmitted() && $logoForm->isValid()) {
            $team = $logoForm->getData();
            $manager->persist($team);
            $manager->flush();
            $this->addFlash(
                'success',
                'Your Team Logo has been successfully updated'
            );

        } elseif ($logoForm->isSubmitted() && !$logoForm->isValid()) {
            $errors = $logoForm->getErrors(true);
            if ($errors->count() > 0) {
                $errorMessage = $errors->current()->getMessage();
                $this->addFlash(
                    'warning',
                    $errorMessage
                );
            }
        }

        // team form
        $teamForm = $this->createForm(EditTeamType::class, $team);
        $teamForm->handleRequest($request);
        
        if ($teamForm->isSubmitted() && $teamForm->isValid()) {
            $team = $teamForm->getData();
            $slugger = new AsciiSlugger();
            $team->setTeamUrl($slugger->slug($teamForm->get('teamName')->getData(), '_'));
            $manager->persist($team);
            $manager->flush();

            $this->addFlash(
                'success',
                'Your Team has been successfully updated'
            );
        }

        // social media form
        $socialMediaForm = $this->createForm(SocialMediaType::class, $socialMedia);
        $socialMediaForm->handleRequest($request);

        if ($socialMediaForm->isSubmitted() && $socialMediaForm->isValid()) {
            $socialMedia = $socialMediaForm->getData();
            $socialMedia->setTeam($team);
            $manager->persist($socialMedia);
            $manager->flush();
            $this->addFlash(
                'success',
                'Your Social Media has been successfully updated'
            );
        }

        return $this->render('pages/team/edit.html.twig', [
            'team' => $team,
            'isPremium' => $isPremium,
            'logoForm' => $logoForm->createView(),
            'teamForm' => $teamForm->createView(),
            'socialMediaForm' => $socialMediaForm->createView()
        ]);
    }

    #[IsGranted('ROLE_USER')]
    #[Route('/account/team/manage/{game}/{teamUrl}', name: 'team.manage', methods: ['GET', 'POST'])]
    public function manage(
        Request $request,
        EntityManagerInterface $manager,
        string $teamUrl,
        string $game
        ): Response
    {
        $isPremium = $this->getUser()->isPremium();
        $gameCode = $manager->getRepository(Game::class)->findOneBy(['code' => $game]);
        $team = $manager->getRepository(Team::class)->findOneBy(['teamUrl' => $teamUrl, 'game' => $gameCode]);
        $inviteLink = $request->getSchemeAndHttpHost() . '/account/team/invite/' . $team->getGame()->getCode() . '/' . $team->getTeamUrl();

        if (!$team || $team->getOwner() !== $this->getUser()) {
            return $this->redirectToRoute('account.index');
        }

        return $this->render('pages/team/manage.html.twig', [
            'team' => $team,
            'isPremium' => $isPremium,
            'inviteLink' => $inviteLink
        ]);
    }

    #[IsGranted('ROLE_USER')]
    #[Route('/account/team/invite/{game}/{teamUrl}', name: 'team.invite', methods: ['GET', 'POST'])]
    public function invite(
        Request $request,
        EntityManagerInterface $manager,
        string $teamUrl,
        string $game
        ): Response
    {        
        $gameCode = $manager->getRepository(Game::class)->findOneBy(['code' => $game]);
        $team = $manager->getRepository(Team::class)->findOneBy(['teamUrl' => $teamUrl, 'game' => $gameCode]);
        $profile = $manager->getRepository(Profile::class)->findOneBy(['user' => $this->getUser(), 'game' => $gameCode]);

        $inviteForm = $this->createForm(InviteTeamType::class);
        $inviteForm->handleRequest($request);
                
        if ($inviteForm->isSubmitted() && $inviteForm->isValid()) {
            $invite = $inviteForm->get('password')->getData();
            if ($profile) {
                if( $team->getPlayers()->count() == 10) {
                    $this->addFlash(
                        'warning',
                        'This team is full'
                    );
                }
                else if ($profile->getTeam() == $team ) {
                    $this->addFlash(
                        'warning',
                        'Your are already joined this team'
                    );
        
                    $referer = $request->headers->get('referer');
                    return new RedirectResponse($referer);
    
                }
                else if ( $profile->getTeam()) {
                    $this->addFlash(
                        'warning',
                        'Your are already in a team'
                    );
        
                    $referer = $request->headers->get('referer');
                    return new RedirectResponse($referer);
                }
                else if ($team->getPassword() == $invite) {
                    
                    $profile->setTeam($team);
                    $manager->persist($profile);
                    $manager->flush();
    
                    $this->addFlash(
                        'success',
                        'Your have successfully joined this team'
                    );
        
                    $referer = $request->headers->get('referer');
                    return new RedirectResponse($referer);
                }
                else if ($team->getPassword() != $invite) {
                    $this->addFlash(
                        'warning',
                        'Password is incorrect'
                    );
    
                    $referer = $request->headers->get('referer');
                    return new RedirectResponse($referer);
                }
            }else{
                $this->addFlash(
                    'warning',
                    'Create '.$gameCode->getCode().' Profile first'
                );

                $referer = $request->headers->get('referer');
                return new RedirectResponse($referer);
            }
        }

        return $this->render('pages/team/invite.html.twig', [
            'inviteForm' => $inviteForm->createView(),
            'team' => $team
        ]);
    }

    #[IsGranted('ROLE_USER')]
    #[Route('/account/team/{teamId}/kick/{playerId}', name: 'team.kick', methods: ['GET'])]
    public function kick(
        EntityManagerInterface $manager,
        string $teamId,
        string $playerId
    ): Response
    {
        $team = $manager->getRepository(Team::class)->findOneBy(['id' => $teamId]);
        $player = $manager->getRepository(Profile::class)->findOneBy(['id' => $playerId]);

        if (!$team || $team->getOwner() !== $this->getUser()) {
            return $this->redirectToRoute('account.dashboard');
        }

        $team->removePlayer($player);
        $manager->flush();

        $this->addFlash(
            'success',
            'A player has been successfully kicked'
        );

        return $this->redirectToRoute('account.dashboard');
    }

    #[IsGranted('ROLE_USER')]
    #[Route('/account/team/{game}/{teamUrl}/delete', name: 'team.delete', methods: ['GET'])]
    public function delete(
        EntityManagerInterface $manager,
        string $teamUrl,
        string $game
    ): Response
    {
        $gameCode = $manager->getRepository(Game::class)->findOneBy(['code' => $game]);
        $team = $manager->getRepository(Team::class)->findOneBy(['teamUrl' => $teamUrl, 'game' => $gameCode]);

        if (!$team || $team->getOwner() !== $this->getUser()) {
            return $this->redirectToRoute('account.dashboard');
        }

        $profiles = $team->getPlayers();

        foreach ($profiles as $profile) {
            $profile->setTeam(null);
        }

        $manager->remove($team);
        $manager->flush();

        $this->addFlash(
            'success',
            'Your Team has been successfully removed'
        );

        return $this->redirectToRoute('account.dashboard');
    }
}
