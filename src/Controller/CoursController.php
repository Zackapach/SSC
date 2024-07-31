<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Form\CoursReservationType;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Cour;
use App\Repository\CourRepository;
use DateInterval;
use DateTime;

class CoursController extends AbstractController
{
    #[Route('/cours', name: 'cours_index')]
    public function index(CourRepository $courRepository): Response
    {
        $cours = $courRepository->findAll();
        $jsonCours = [];

        foreach($cours as $cour) {
            $jsonCours[] = [
                'title' => $cour->getTitle(),
                'start' => $cour->getCalendrier()->format('Y-m-d H:i:s'),
                'end' => $cour->getCalendrier()->add(new DateInterval('PT'.$cour->getDuration().'H'))->format('Y-m-d H:i:s'),
                'id' => $cour->getId()
            ];
        }


        return $this->render('cours/cour.html.twig', [
            'cours' => $jsonCours,
        ]);
    }
    #[Route('/cours/reserver/{id}', name: 'cours_reserver')]
    public function reserver(Request $request, Cour $cour): Response
    {
        dd($cour);
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
