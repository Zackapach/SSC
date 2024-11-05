<?php

namespace App\Controller\Admin;

use App\Entity\Cour;
use App\Entity\Zone;
use App\Form\CourseType;
use App\Form\ZoneType;
use App\Repository\CourRepository;
use App\Repository\ZoneRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_ADMIN')]
#[Route('/zones', name: 'app_zones_')]
class ZoneController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(ZoneRepository $zoneRepository): Response
    {
        $zones = $zoneRepository->findAll();

        return $this->render('zones/index.html.twig', [
            'zones' => $zones,
        ]);
    }

    #[Route('/new', name: 'new')]
    public function new(Request $request, EntityManagerInterface $entityManagerInterface): Response
    {
        $zone = new Zone();
        $form = $this->createForm(ZoneType::class, $zone);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $zone->setUser($this->getUser());

            $entityManagerInterface->persist($zone);
            $entityManagerInterface->flush();

            return $this->redirectToRoute('app_zones_index');
        }

        return $this->render('zones/new.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/edit/{id}', name: 'edit')]
    public function edit(Zone $zone, Request $request, EntityManagerInterface $entityManagerInterface): Response
    {
        $form = $this->createForm(ZoneType::class, $zone);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManagerInterface->flush();

            return $this->redirectToRoute('app_zones_index');
        }

        return $this->render('zones/new.html.twig', [
            'form' => $form,
        ]);
    }
}
