<?php

namespace App\Controller;

use App\Entity\Projet;
use App\Repository\ProjetRepository;
use App\Repository\TacheRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ProjetController extends AbstractController
{
    #[Route('/', name: 'app_projet')]
    public function index(ProjetRepository $repository): Response
    {
        $projet  = $repository->findAll();

        return $this->render('projet/index.html.twig', [
            'controller_name' => 'ProjetController', 'projet' => $projet
        ]);
    }

    #[Route('/projet/{id}', name: 'projet.show', requirements: ['id' => '\d+'])]
    public function show(TacheRepository $repository): Response
    {
        
        return $this->render('tache/index.html.twig', [
            'controller_name' => 'TacheController', 'tache' => $tache
        ]);
    }

}