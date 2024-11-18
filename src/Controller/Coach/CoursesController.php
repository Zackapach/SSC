<?php

namespace App\Controller\Coach;

use App\Entity\Course;
use App\Form\CourseType;
use App\Entity\User;
use App\Repository\CourseRepository;
use App\Repository\ReservationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

use function PHPUnit\Framework\throwException;

class CoursesController extends AbstractController
{
    #[Route('/courses', name: 'app_courses')]
    public function index(CourseRepository $courseRepository, ReservationRepository $reservationRepository): Response
    {


        $user = $this->getUser();

        if (!$user) {
            throw new \LogicException('Vous devez être connecté pour accéder à cette page');
        }

        $courses = [];
        if($user->getRoles() == ["ROLE_COACH"]){
            $courses = $courseRepository->findBy(['coach' => $user]);
        }
        else if($user->getRoles() == ["ROLE_USER"]){
            $courses = $reservationRepository->findBy(['user' => $user]);
        }


        return $this->render('courses/index.html.twig', [
            'courses' => $courses,
        ]);
    }

    #[Route('/courses/new', name: 'app_courses_new')]
    #[IsGranted('ROLE_COACH')]
    public function new(Request $request, EntityManagerInterface $entityManagerInterface): Response
    {
        $course = new Course;
        $form = $this->createForm(CourseType::class, $course);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $course->setCoach($this->getUser());
            
            $entityManagerInterface->persist($course);
            $entityManagerInterface->flush();

            return $this->redirectToRoute('app_courses');
        }

        return $this->render('courses/new.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/courses/edit/{id}', name: 'app_courses_edit')]
    #[IsGranted('ROLE_COACH')]
    public function edit(Course $course, Request $request, EntityManagerInterface $entityManagerInterface): Response
    {
        $form = $this->createForm(CourseType::class, $course);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $entityManagerInterface->flush();

            return $this->redirectToRoute('app_courses');
        }

        return $this->render('courses/new.html.twig', [
            'form' => $form,
        ]);
    }
}
