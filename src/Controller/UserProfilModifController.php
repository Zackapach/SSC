<?php

namespace App\Controller;

use App\Entity\UserProfil;
use App\Form\UserProfilType;
use App\Repository\UserProfilRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/user/profil/modif')]
class UserProfilModifController extends AbstractController
{
    #[Route('/', name: 'app_user_profil_modif_index', methods: ['GET'])]
    public function index(UserProfilRepository $userProfilRepository): Response
    {
        return $this->render('user_profil_modif/index.html.twig', [
            'user_profils' => $userProfilRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_user_profil_modif_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $userProfil = new UserProfil();
        $form = $this->createForm(UserProfilType::class, $userProfil);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($userProfil);
            $entityManager->flush();

            return $this->redirectToRoute('app_user_profil_modif_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('user_profil_modif/new.html.twig', [
            'user_profil' => $userProfil,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_user_profil_modif_show', methods: ['GET'])]
    public function show(UserProfil $userProfil): Response
    {
        return $this->render('user_profil_modif/show.html.twig', [
            'user_profil' => $userProfil,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_user_profil_modif_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, UserProfil $userProfil, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(UserProfilType::class, $userProfil);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_user_profil_modif_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('user_profil_modif/edit.html.twig', [
            'user_profil' => $userProfil,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_user_profil_modif_delete', methods: ['POST'])]
    public function delete(Request $request, UserProfil $userProfil, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $userProfil->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($userProfil);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_user_profil_modif_index', [], Response::HTTP_SEE_OTHER);
    }
}
