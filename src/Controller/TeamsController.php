<?php

namespace App\Controller;

use App\Entity\Teams;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;

class TeamsController extends AbstractController
{
    #[Route (path:"/teams", name:"app_teams")]
    public function index(): Response
    {
        return $this->render('teams/index.html.twig');
    }

    #[Route('/team/create/validate', name: 'app_teams_create_validate')]
    public function create(EntityManagerInterface $entityManager): Response
    {
        $name = $_GET['name'];
        $team = new Teams();
        $team->setName($name);

        $entityManager->persist($team);
        $entityManager->flush();

        return new Response('Équipe créée avec l\'ID : '.$team->getId());
    }

    #[Route('/team/create', name: 'app_teams_create')]
    public function createTeam(): Response
    {
        return $this->render('teams/create.html.twig');
    }
}