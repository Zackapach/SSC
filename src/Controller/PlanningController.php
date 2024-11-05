<?php

namespace App\Controller;

use App\Entity\Planning;
use App\Form\PlanningType;
use App\Repository\PlanningRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PlanningController extends AbstractController
{
    #[Route('/planning', name: 'app_planning')]
    public function index(Request $request, PlanningRepository $planningRepository): Response
    {
        $plannings = $planningRepository->findAll();
        $jsonPlannings = [];
        foreach($plannings as $planning) {
            $jsonPlannings[] = [
                'title' => $planning->getCour()->getTitle(),
                'startTime' => $planning->getHeureDebut()->format('H:i:s'),
                'endTime' => $planning->getHeureFin()->format('H:i:s'),
                'daysOfWeek' => $planning->getDaysOfWeek(),
                'color' => $planning->getColor(),
                'id' => $planning->getCour()->getId(),
//                'url' => $this->generateUrl('app_courses_edit', ['id' => $cour->getId()])
            ];
        }

        // Rendre la vue avec le formulaire
        return $this->render('planning/planning.html.twig', [
            'jsonPlannings' => $jsonPlannings
        ]);
    }
}