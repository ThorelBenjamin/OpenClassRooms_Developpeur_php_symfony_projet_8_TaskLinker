<?php

namespace App\Controller;

use App\Entity\Projet;
use App\Entity\Tache;
use App\Form\TacheType;
use App\Repository\ProjetRepository;
use App\Repository\TacheRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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

    #[Route('/projet/{id}/addTask', name: 'tache.add')]
    public function add(Projet $projet, Request $request, EntityManagerInterface $em): Response
    {
        $tache = new Tache();
        $tache->setProjet($projet);
        $form = $this->createForm(TacheType::class, $tache);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($tache);
            $em->flush();
        }

        return $this->render('tache/add.html.twig', [
            'controller_name' => 'TacheController', 'form' => $form->createView()
        ]);
    }

    #[Route('/tache/{id}/update', name: 'tache.update')]
    public function update(Tache $tache, Request $request, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(TacheType::class, $tache);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($tache);
            $em->flush();
        }
        return $this->render('tache/update.html.twig', [
            'controller_name' => 'TacheController', 'form' => $form->createView(), 'tache' => $tache
        ]);
    }

    #[Route('/tache/{id}/supprimer', name: 'tache.delete', requirements: ['id' => '\d+'])]
    public function delete(TacheRepository $repository, Request $request, int $id, EntityManagerInterface $em): Response
    {
        $tache = $repository->find($id);
        if (!$tache) {
            return $this->redirectToRoute('projet.index');
        }
        $em->remove($tache);
        $em->flush();
        return $this->redirectToRoute('projet.index');
    }

}
