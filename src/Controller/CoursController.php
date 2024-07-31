<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Form\CoursReservationType;

class CoursController extends AbstractController
{
    #[Route('/cours', name: 'app_cours')]
    public function index(): Response
    {
        return $this->render('cours/cour.html.twig', [
            'controller_name' => 'CoursController',
        ]);
    }
    #[Route('/cours/reserver/{id}', name: 'cours_reserver')]
    public function reserver(Request $request, Cour $cour): Response
    {
        $form = $this->createForm(CoursReservationType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Logique de réservation (par exemple, enregistrer les informations de l'utilisateur)

            $this->addFlash('success', 'Votre réservation a été enregistrée.');

            return $this->redirectToRoute('cours_index');
        }

        return $this->render('cours/reserver.html.twig', [
            'cours' => $cour,
            'form' => $form->createView(),
        ]);
    }

}
