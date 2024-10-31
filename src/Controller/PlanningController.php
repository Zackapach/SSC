<?php

namespace App\Controller;

use App\Entity\Planning;
use App\Form\PlanningType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PlanningController extends AbstractController
{
    #[Route('/planning', name: 'app_planning')]
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        // Créer une nouvelle instance de l'entité Planning
        $planning = new Planning();

        // Créer le formulaire en utilisant la classe PlanningType
        $form = $this->createForm(PlanningType::class, $planning);

        // Traiter la requête HTTP (vérifie si le formulaire a été soumis)
        $form->handleRequest($request);

        // Vérifier si le formulaire est soumis et valide
        if ($form->isSubmitted() && $form->isValid()) {
            // Enregistrer le nouveau planning en base de données
            $entityManager->persist($planning);
            $entityManager->flush();

            // Ajouter un message flash pour informer l'utilisateur du succès de l'opération
            $this->addFlash('success', 'Le cours a été réservé avec succès.');

            // Rediriger vers une autre route (par exemple vers la liste des plannings)
            return $this->redirectToRoute('app_planning');
        }

        // Rendre la vue avec le formulaire
        return $this->render('planning/planning.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}