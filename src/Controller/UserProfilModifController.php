<?php

namespace App\Controller;

use App\Entity\UserProfil;
use App\Form\UserProfilType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/user/profil', name:'app_user_profil_') ]
class UserProfilModifController extends AbstractController
{
    #[Route('/new', name: 'modif_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $userProfil = new UserProfil();
        $form = $this->createForm(UserProfilType::class, $userProfil);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($userProfil);
            $entityManager->flush();

            return $this->redirectToRoute('app_user_profil_modif_index', [], Response::HTTP_SEE_OTHER); // Assurez-vous que cette route existe
        }

        return $this->render('user_profil_modif/new.html.twig', [
            'user_profil' => $userProfil,
            'form' => $form,
        ]);
    }

    #[Route('/edit', name: 'modif_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, EntityManagerInterface $entityManager): Response
    {
        $userProfil = $this->getUser()->getUserProfil();
        $form = $this->createForm(UserProfilType::class, $userProfil);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_user_profil_modif_index', [], Response::HTTP_SEE_OTHER); // Assurez-vous que cette route existe
        }

        return $this->render('user_profil_modif/edit.html.twig', [
            'user_profil' => $userProfil,
            'form' => $form,
        ]);
    }
}

