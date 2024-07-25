<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use App\Form\ChangePasswordType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Form\UserType;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserController extends AbstractController
{
    #[Route('/user/update', name: 'app_user_update')]
    public function update(
        Request $request,
        UserPasswordHasherInterface $userPasswordHasher,
        EntityManagerInterface $entityManager
    ): Response {
        $user = $this->getUser();
        if (!$user) {
            throw $this->createAccessDeniedException('Vous devez être connecté pour accéder à cette page.');
        }

        $form = $this->createForm(ChangePasswordType::class);
        $userForm = $this->createForm(UserType::class);

        $form->handleRequest($request);
        $userForm->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if (
                $userPasswordHasher->isPasswordValid(
                    $this->getUser(),
                    $form->get('currentPassword')->getData()
                )
            ) {
            // encode the plain password
                $user->setPassword(
                    $userPasswordHasher->hashPassword(
                        $user,
                        $form->get('newPassword')->getData()
                    )
                );

                $entityManager->persist($user);
                $entityManager->flush();

                $this->addFlash('success', 'Votre mot de passe a été mis à jour avec succès.');

                return $this->redirectToRoute('home');
            }
        }

        if ($userForm->isSubmitted() && $userForm->isValid()) {
            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash('success', 'Votre mot de passe a été mis à jour avec succès.');

            return $this->redirectToRoute('home');
        }

        return $this->render('user/update.html.twig', [
            'form' => $form,
            'userForm' => $userForm,
        ]);
    }
}
