<?php

namespace App\Controller;

use App\Entity\Enigma;
use App\Entity\Game;
use App\Form\EnigmaType;
use App\Repository\EnigmaRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/teacher/game/{gameId}/enigma')]
#[IsGranted('ROLE_PROF')]
class EnigmaController extends AbstractController
{
    #[Route('/', name: 'app_enigma_index', methods: ['GET'])]
    public function index(int $gameId, Game $game, EnigmaRepository $enigmaRepository): Response
    {
        $this->denyAccessUnlessGranted('view', $game);
        
        $enigmas = $enigmaRepository->findByGame($gameId);
        
        return $this->render('enigma/index.html.twig', [
            'game' => $game,
            'enigmas' => $enigmas,
        ]);
    }

    #[Route('/new', name: 'app_enigma_new', methods: ['GET', 'POST'])]
    public function new(Request $request, int $gameId, Game $game, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('edit', $game);
        
        $enigma = new Enigma();
        $enigma->setGame($game);
        
        $form = $this->createForm(EnigmaType::class, $enigma);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($enigma);
            $entityManager->flush();

            $this->addFlash('success', 'L\'énigme a été créée avec succès.');
            return $this->redirectToRoute('app_enigma_index', ['gameId' => $gameId]);
        }

        return $this->render('enigma/new.html.twig', [
            'game' => $game,
            'enigma' => $enigma,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_enigma_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, int $gameId, Game $game, Enigma $enigma, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('edit', $game);
        
        $form = $this->createForm(EnigmaType::class, $enigma);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            $this->addFlash('success', 'L\'énigme a été modifiée avec succès.');
            return $this->redirectToRoute('app_enigma_index', ['gameId' => $gameId]);
        }

        return $this->render('enigma/edit.html.twig', [
            'game' => $game,
            'enigma' => $enigma,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_enigma_delete', methods: ['POST'])]
    public function delete(Request $request, int $gameId, Game $game, Enigma $enigma, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('delete', $game);
        
        if ($this->isCsrfTokenValid('delete'.$enigma->getId(), $request->request->get('_token'))) {
            $entityManager->remove($enigma);
            $entityManager->flush();
            
            $this->addFlash('success', 'L\'énigme a été supprimée avec succès.');
        }

        return $this->redirectToRoute('app_enigma_index', ['gameId' => $gameId]);
    }
}
