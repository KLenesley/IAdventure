<?php

namespace App\Controller;

use App\Entity\Game;
use App\Repository\GameSessionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/teacher/dashboard')]
#[IsGranted('ROLE_PROF')]
class DashboardController extends AbstractController
{
    #[Route('/', name: 'app_dashboard')]
    public function index(): Response
    {
        return $this->render('dashboard/index.html.twig');
    }

    #[Route('/game/{id}', name: 'app_dashboard_game')]
    public function monitorGame(Game $game, GameSessionRepository $gameSessionRepository): Response
    {
        $this->denyAccessUnlessGranted('view', $game);
        
        $activeSessions = $gameSessionRepository->findActiveSessionsByGame($game->getId());
        
        return $this->render('dashboard/game.html.twig', [
            'game' => $game,
            'gameSessions' => $activeSessions,
        ]);
    }
}
