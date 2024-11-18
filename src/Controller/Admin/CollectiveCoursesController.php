<?php

namespace App\Controller\Admin;

use App\Entity\Course;
use App\Entity\User;
use App\Form\CourseType;
use App\Repository\CourseRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\ExpressionLanguage\Expression;



#[Route('/collective/courses', name: 'app_collective_courses_')]
class CollectiveCoursesController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(CourseRepository $courseRepository): Response
    {
        $courses = $courseRepository->findBy(['coach' => $this->getUser()]);

        return $this->render('courses/index.html.twig', [
            'courses' => $courses,
        ]);
    }

    #[Route('/new', name: 'new')]
    public function new(Request $request, EntityManagerInterface $entityManagerInterface): Response
    {
        $course = new Course();
        $form = $this->createForm(CourseType::class, $course);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $course->setCoach($this->getUser());
            $date = $form->get('duration')->getData();
            $course->setDuration($date->getTimestamp());

            $entityManagerInterface->persist($course);
            $entityManagerInterface->flush();

            return $this->redirectToRoute('app_collective_courses_index');
        }

        return $this->render('courses/new.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/edit/{id}', name: 'edit')]
    #[IsGranted(new Expression('is_granted("ROLE_ADMIN") or is_granted("ROLE_COACH")'))]
    public function edit(Course $course, Request $request, EntityManagerInterface $entityManagerInterface): Response
    {
        $form = $this->createForm(CourseType::class, $course);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManagerInterface->flush();

            return $this->redirectToRoute('app_collective_courses_index');
        }

        return $this->render('courses/new.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/remove/{id}', name: 'remove', methods: ['POST'])]
    #[IsGranted(new Expression('is_granted("ROLE_ADMIN") or is_granted("ROLE_COACH")'))]
    public function remove(Course $course, Request $request, EntityManagerInterface $entityManagerInterface): Response
    {
        $submittedToken = $request->request->get('_token');

        if ($this->isCsrfTokenValid('delete' . $course->getId(), $submittedToken)) {
            $entityManagerInterface->remove($course);
            $entityManagerInterface->flush();

            $this->addFlash('success', 'Course removed successfully.');
        } else {
            $this->addFlash('error', 'Invalid CSRF token.');
        }

        return $this->redirectToRoute('app_collective_courses_index');
    }
}
