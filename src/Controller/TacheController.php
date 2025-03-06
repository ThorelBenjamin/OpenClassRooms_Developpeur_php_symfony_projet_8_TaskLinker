<?php

namespace App\Controller;

use App\Entity\Tache;
use App\Repository\TacheRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class TacheController extends AbstractController
{
    #[Route('/tache', name: 'app_tache')]
    public function index(TacheRepository $repository): Response
    {
        $taches = $repository->findAll();

        return $this->render('tache/index.html.twig', [
            'controller_name' => 'TacheController', 'tache' => $taches
        ]);
    }

}
