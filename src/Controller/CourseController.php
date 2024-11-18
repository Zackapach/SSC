<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Form\CourseReservationType;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Course;
use App\Entity\Reservation;
use App\Form\ReservationType;
use App\Repository\CourseRepository;
use Doctrine\ORM\EntityManagerInterface;


class CourseController extends AbstractController
{
    // Planning de course disponibles
    #[Route('/course', name: 'courses')]
    public function index(CourseRepository $courseRepository): Response
    {
        $courses = $courseRepository->createQueryBuilder('c')
            ->where('c.availablePlaces > :min_places')
            ->setParameter('min_places', 0)
            ->getQuery()
            ->getResult();

        $jsonCourse = [];
        foreach ($courses as $course) {
            $minutes = $course->getDuration();
            $jsonCourse[] = [
                'title' => $course->getTitle(),
                'start' => $course->getStartDatetime()->format('Y-m-d H:i:s'),
                'end' => $course->getStartDatetime()->modify("+{$minutes} minutes")->format('Y-m-d H:i:s'),
                'zone' => $course->getZone()->getId(),
                'id' => $course->getId(),
                'url' => $this->generateUrl('app_show_course', ['id' => $course->getId()])
                // 'color' => 'orange'
            ];
        }

        return $this->render('course/course.html.twig', [
            'course' => $jsonCourse,
        ]);
    }


    // Afficher les infos d'un course
    #[Route('/show/course/{id}', name: 'app_show_course')]
    public function show(CourseRepository $courseRepository, int $id): Response
    {
       
        $course = $courseRepository->find($id);

        
        if (!$course) {
            throw $this->createNotFoundException("Aucun cours n'a été trouvé");
        }

        
        return $this->render('course/showCourse.html.twig', [
            'course' => $course,
        ]);
    }



    #[Route('/course/reserver/{id}', name: 'course_reserver')]
   // 
    public function reserver(Request $request,int $id,CourseRepository $courseRepository,EntityManagerInterface $entityManager
    ): Response {
    
        $user = $this->getUser();
        $course = $courseRepository->find($id);
    
        if (!$course) {
            $this->addFlash('error', 'Le cours demandé n\'existe pas.');
            return $this->redirectToRoute('course_index');
        }
    
        $reservation = new Reservation();
    
        $reservation->setUser($user)
                    ->setCourse($course)
                    ->setStatus('en_attente_confirmation')
                    ->setCreatedAt(new \DateTimeImmutable())
                    ->setUpdatedAt(new \DateTimeImmutable());
    
        // Persister et sauvegarder la réservation
        $entityManager->persist($reservation);
        $entityManager->flush();
    
        $this->addFlash('success', 'Votre réservation a été enregistrée.');
        return $this->redirectToRoute('app_reservation_show', ['id' => $reservation->getId()]);
    }


    
}
