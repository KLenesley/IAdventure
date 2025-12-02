<?php

namespace App\Controller;

use App\Entity\Game;
use App\Entity\GameSession;
use App\Entity\Team;
use App\Entity\TeamProgress;
use App\Entity\TeamSession;
use App\Form\TeamType;
use App\Repository\EnigmaRepository;
use App\Repository\GameSessionRepository;
use App\Repository\TeamRepository;
use App\Repository\TeamSessionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/play')]
class PlayController extends AbstractController
{
    #[Route('/game/{id}', name: 'app_play_game_select')]
    public function selectGame(Game $game): Response
    {
        return $this->render('play/select_game.html.twig', [
            'game' => $game,
        ]);
    }

    #[Route('/game/{id}/join', name: 'app_play_game_join', methods: ['GET', 'POST'])]
    public function joinGame(
        Request $request,
        Game $game,
        EntityManagerInterface $entityManager,
        SessionInterface $session,
        GameSessionRepository $gameSessionRepository
    ): Response {
        $team = new Team();
        $form = $this->createForm(TeamType::class, $team);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Create or get active game session
            $activeSessions = $gameSessionRepository->findActiveSessionsByGame($game->getId());
            
            if (empty($activeSessions)) {
                $gameSession = new GameSession();
                $gameSession->setGame($game);
                $entityManager->persist($gameSession);
            } else {
                $gameSession = $activeSessions[0];
            }

            // Save team
            $entityManager->persist($team);
            
            // Create team session
            $teamSession = new TeamSession();
            $teamSession->setTeam($team);
            $teamSession->setGameSession($gameSession);
            $entityManager->persist($teamSession);
            
            $entityManager->flush();

            // Store team session in PHP session
            $session->set('team_session_id', $teamSession->getId());

            return $this->redirectToRoute('app_play_game', [
                'id' => $game->getId(),
                'teamSessionId' => $teamSession->getId()
            ]);
        }

        return $this->render('play/join.html.twig', [
            'game' => $game,
            'form' => $form,
        ]);
    }

    #[Route('/game/{id}/play/{teamSessionId}', name: 'app_play_game')]
    public function playGame(
        Game $game,
        int $teamSessionId,
        TeamSessionRepository $teamSessionRepository,
        EnigmaRepository $enigmaRepository
    ): Response {
        $teamSession = $teamSessionRepository->find($teamSessionId);
        
        if (!$teamSession) {
            throw $this->createNotFoundException('Session d\'équipe non trouvée');
        }

        $enigmas = $enigmaRepository->findByGame($game->getId());
        $currentEnigmaOrder = $teamSession->getCurrentEnigmaOrder();
        
        $currentEnigma = null;
        foreach ($enigmas as $enigma) {
            if ($enigma->getOrder() === $currentEnigmaOrder) {
                $currentEnigma = $enigma;
                break;
            }
        }

        // If no current enigma, start with the first one
        if (!$currentEnigma && !empty($enigmas)) {
            $currentEnigma = $enigmas[0];
            $teamSession->setCurrentEnigmaOrder($currentEnigma->getOrder());
        }

        return $this->render('play/game.html.twig', [
            'game' => $game,
            'teamSession' => $teamSession,
            'currentEnigma' => $currentEnigma,
            'enigmas' => $enigmas,
        ]);
    }

    #[Route('/game/{id}/check/{teamSessionId}', name: 'app_play_check', methods: ['POST'])]
    public function checkAnswer(
        Request $request,
        Game $game,
        int $teamSessionId,
        TeamSessionRepository $teamSessionRepository,
        EnigmaRepository $enigmaRepository,
        EntityManagerInterface $entityManager
    ): Response {
        $teamSession = $teamSessionRepository->find($teamSessionId);
        
        if (!$teamSession) {
            throw $this->createNotFoundException('Session d\'équipe non trouvée');
        }

        $answer = $request->request->get('answer');
        $enigmas = $enigmaRepository->findByGame($game->getId());
        $currentEnigmaOrder = $teamSession->getCurrentEnigmaOrder();
        
        $currentEnigma = null;
        foreach ($enigmas as $enigma) {
            if ($enigma->getOrder() === $currentEnigmaOrder) {
                $currentEnigma = $enigma;
                break;
            }
        }

        if (!$currentEnigma) {
            $this->addFlash('error', 'Énigme non trouvée');
            return $this->redirectToRoute('app_play_game', [
                'id' => $game->getId(),
                'teamSessionId' => $teamSessionId
            ]);
        }

        // Log progress
        $progress = new TeamProgress();
        $progress->setTeamSession($teamSession);
        $progress->setEnigma($currentEnigma);
        
        if (strtolower(trim($answer)) === strtolower(trim($currentEnigma->getSecretCode()))) {
            // Correct answer
            $progress->setAction('completed');
            $progress->setDetails('Code correct: ' . $answer);
            
            // Move to next enigma
            $nextOrder = $currentEnigmaOrder + 1;
            $hasNextEnigma = false;
            
            foreach ($enigmas as $enigma) {
                if ($enigma->getOrder() === $nextOrder) {
                    $hasNextEnigma = true;
                    break;
                }
            }
            
            if ($hasNextEnigma) {
                $teamSession->setCurrentEnigmaOrder($nextOrder);
                $this->addFlash('success', 'Bravo ! Vous avez trouvé le bon code. Passez à l\'énigme suivante.');
            } else {
                // Game completed
                $teamSession->setStatus('completed');
                $teamSession->setCompletedAt(new \DateTime());
                $this->addFlash('success', 'Félicitations ! Vous avez terminé le jeu !');
            }
        } else {
            // Wrong answer
            $progress->setAction('failed_attempt');
            $progress->setDetails('Code incorrect: ' . $answer);
            $this->addFlash('error', 'Code incorrect, réessayez !');
        }
        
        $entityManager->persist($progress);
        $entityManager->flush();

        return $this->redirectToRoute('app_play_game', [
            'id' => $game->getId(),
            'teamSessionId' => $teamSessionId
        ]);
    }
}
