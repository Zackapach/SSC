<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Form\CoursReservationType;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Cour;
use App\Repository\CourRepository;
use App\Repository\PlanningRepository;
use DateInterval;
use DateTime;

class CoursController extends AbstractController
{
    #[Route('/cours', name: 'cours_index')]
    public function index(PlanningRepository $PlanningRepository): Response
    {
        $plannings = $PlanningRepository->findAll();
        $jsonCours = [];
        foreach($plannings as $date) {
            $jsonCours[] = [
                'title' => $date->getCour()->getTitle(),
                'start' => $date->getDate()->modify($date->getHeureDebut()->format('H:i:s'))->format('Y-m-d H:i:s'),
                'end' => $date->getDate()->modify($date->getHeureFin()->format('H:i:s'))->format('Y-m-d H:i:s'),
                'zone' => $date->getZone()->getId(),
                'id' => $date->getCour()->getId(),
                // 'color' => 'orange'
            ];
        }

        //dd($jsonCours);

        return $this->render('cours/cour.html.twig', [
            'cours' => $jsonCours,
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

        return $this->render('coursreservation/coursreservation.html.twig', [
            'cours' => $cour,
            'coursreservation' => $form->createView(),
        ]);
    }

}
