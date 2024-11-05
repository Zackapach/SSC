<?php

namespace App\Controller;

use App\Entity\Reservation;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Form\CoursReservationType;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Cour;
use App\Repository\CourRepository;

class CoursController extends AbstractController
{
    #[Route('/cours', name: 'cours_index')]
    public function index(CourRepository $courRepository): Response
    {
        $cours = $courRepository->findBy(['user' => $this->getUser()]);
        $jsonCours = [];
        foreach($cours as $cour) {
            $minutes = $cour->getDuration()->getTimestamp() / 60;
            $jsonCours[] = [
                'title' => $cour->getTitle(),
                'start' => $cour->getCalendrier()->format('Y-m-d H:i:s'),
                'end' => $cour->getCalendrier()->modify("+{$minutes} minutes")->format('Y-m-d H:i:s'),
                'zone' => $cour->getZone()->getId(),
                'id' => $cour->getId(),
                'url' => $this->generateUrl('app_courses_edit', ['id' => $cour->getId()])
                // 'color' => 'orange'
            ];
        }

        return $this->render('cours/cour.html.twig', [
            'cours' => $jsonCours,
        ]);
    }
    #[Route('/cours/reserver/{id}/{date}', name: 'cours_reserver')]
    public function reserver(Cour $cour, string $date, EntityManagerInterface $entityManager): Response
    {
        $reservation = new Reservation();
        $reservation
            ->setCour($cour)
            ->setUser($this->getUser())
            ->setStatus('pending')
            ->setReservationDate(new \DateTimeImmutable($date))
        ;

        $entityManager->persist($reservation);
        $entityManager->flush();

        $this->addFlash('success', 'Votre réservation a été enregistrée.');

        return $this->redirectToRoute('home');
    }

}
