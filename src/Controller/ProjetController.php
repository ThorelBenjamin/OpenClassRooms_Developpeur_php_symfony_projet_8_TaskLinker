<?php

namespace App\Controller;

use App\Entity\Projet;
use App\Repository\ProjetRepository;
use App\Repository\StatutRepository;
use App\Repository\TacheRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ProjetController extends AbstractController
{
    #[Route('/', name: 'projet.index')]
    public function index(ProjetRepository $repository): Response
    {
        $projet  = $repository->findAll();

        return $this->render('projet/index.html.twig', [
            'controller_name' => 'ProjetController', 'projet' => $projet
        ]);
    }

    #[Route('/projet/{id}', name: 'projet.show', requirements: ['id' => '\d+'])]
    public function show(Request $request, int $id, TacheRepository $repository, ProjetRepository $projetRepository): Response
    {
        $taches = $repository->findByProjetOrderedByStatut($id);
        $projet = $projetRepository->find($id);

        return $this->render('projet/projet.html.twig', [
            'taches' => $taches, 'projet' => $projet
        ]);
    }

}