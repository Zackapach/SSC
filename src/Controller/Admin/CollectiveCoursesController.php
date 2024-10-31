<?php

namespace App\Controller\Coach;

use App\Entity\Cour;
use App\Form\CourseType;
use App\Repository\CourRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_COACH')]
#[Route('/collective/courses', name: 'app_collective_courses_')]
class CollectiveCoursesController extends AbstractController
{
    ////////////////-----------------------------------//
    // WIP Cours collectif
    ////////////////-----------------------------------//

    #[Route('/', name: 'index')]
    public function index(CourRepository $courRepository): Response
    {
        $courses = $courRepository->findBy(['user' => $this->getUser()]);

        return $this->render('courses/index.html.twig', [
            'courses' => $courses,
        ]);
    }

    #[Route('/new', name: 'new')]
    public function new(Request $request, EntityManagerInterface $entityManagerInterface): Response
    {
        // WIP Cours collectif
        $course = new Cour;
        $form = $this->createForm(CourseType::class, $course);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $course->setUser($this->getUser());
            $date = $form->get('duration')->getData();
            $course->setDuration($date->getTimestamp() / 60);
            
            $entityManagerInterface->persist($course);
            $entityManagerInterface->flush();

            return $this->redirectToRoute('app_courses');
        }

        return $this->render('courses/new.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/courses/edit/{id}', name: 'app_courses_edit')]
    public function edit(Cour $course, Request $request, EntityManagerInterface $entityManagerInterface): Response
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
