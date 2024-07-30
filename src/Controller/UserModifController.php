<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
// use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

#[Route('/user/modif')]
class UserModifController extends AbstractController
{
    #[Route('/', name: 'app_user_modif_index', methods: ['GET'])]
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('user_modif/index.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_user_modif_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('app_user_modif_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('user_modif/new.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }


    #[Route('/{id}/edit', name: 'app_user_modif_edit', methods: ['GET', 'POST'])]
    public function edit(
        Request $request, 
        User $user, 
        EntityManagerInterface $entityManager, 
        UserPasswordHasherInterface $userPasswordHasher,  
        MailerInterface $mailer,
        // TokenStorageInterface $tokenStorage,
        ): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // Check if the password field is set and not empty
            $newPassword = $form->get('password')->getData();
            if ($newPassword) {
                // Encode the new password
                $user->setPassword(
                    $userPasswordHasher->hashPassword(
                        $user,
                        $newPassword
                    )
                );
                
                // Envoyer l'e-mail de confirmation
                $email = (new Email())
                    ->from('noreply@example.com')
                    ->to($user->getEmail())
                    ->subject('Confirmation de changement de mot de passe')
                    ->text('Votre mot de passe a été changé avec succès.');

                $mailer->send($email);
            }
            $entityManager->flush();

            return $this->redirectToRoute('app_user_modif_edit', ['id' => $user->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->render('user_modif/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_user_modif_delete', methods: ['POST'])]
    public function delete(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $user->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_user_modif_index', [], Response::HTTP_SEE_OTHER);
    }
}




// namespace App\Controller;

// use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
// use Symfony\Component\HttpFoundation\Response;
// use Symfony\Component\Routing\Annotation\Route;
// use App\Entity\User;
// use App\Form\ChangePasswordType;
// use App\Form\ChangeEmailType;
// use App\Form\DeleteAccountType;
// use Doctrine\ORM\EntityManagerInterface;
// use Symfony\Component\HttpFoundation\Request;
// use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
// use Symfony\Component\Mailer\MailerInterface;
// use Symfony\Component\Mime\Email;
// use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

// class UserController extends AbstractController
// {
//     #[Route('/user/edit', name: 'app_user_edit')]
//     public function edit(
//         Request $request,
//         UserPasswordHasherInterface $passwordHasher,
//         EntityManagerInterface $entityManager,
//         TokenStorageInterface $tokenStorage,
//         MailerInterface $mailer
//     ): Response {
//         /** @var User $user */
//         $user = $this->getUser();

//         if (!$user instanceof User) {
//             throw $this->createAccessDeniedException('Vous devez être connecté pour accéder à cette page.');
//         }

//         $changeEmailForm = $this->createForm(ChangeEmailType::class, $user);
//         $changePasswordForm = $this->createForm(ChangePasswordType::class);
//         $deleteAccountForm = $this->createForm(DeleteAccountType::class);

//         $changeEmailForm->handleRequest($request);
//         $changePasswordForm->handleRequest($request);
//         $deleteAccountForm->handleRequest($request);

//         if ($changeEmailForm->isSubmitted() && $changeEmailForm->isValid()) {
//             $entityManager->flush();
//             $this->addFlash('success', 'Votre email a été mis à jour avec succès.');
//             return $this->redirectToRoute('app_user_edit');
//         }

//         if ($changePasswordForm->isSubmitted() && $changePasswordForm->isValid()) {
//             $currentPassword = $changePasswordForm->get('currentPassword')->getData();
//             $newPassword = $changePasswordForm->get('newPassword')->getData();

//             if ($passwordHasher->isPasswordValid($user, $currentPassword)) {
//                 $user->setPassword($passwordHasher->hashPassword($user, $newPassword));
//                 $entityManager->flush();

//                 // Envoyer l'e-mail de confirmation
//                 $email = (new Email())
//                     ->from('noreply@example.com')
//                     ->to($user->getEmail())
//                     ->subject('Confirmation de changement de mot de passe')
//                     ->text('Votre mot de passe a été changé avec succès.');

//                 $mailer->send($email);

//                 $this->addFlash('success', 'Votre mot de passe a été changé avec succès.');
//                 return $this->redirectToRoute('app_user_edit');
//             } else {
//                 $this->addFlash('error', 'Mot de passe actuel incorrect.');
//             }
//         }

//         if ($deleteAccountForm->isSubmitted() && $deleteAccountForm->isValid()) {
//             $password = $deleteAccountForm->get('password')->getData();
//             if ($passwordHasher->isPasswordValid($user, $password)) {

//                 $tokenStorage->setToken(null);
//                 $request->getSession()->invalidate();

//                 $entityManager->remove($user);
//                 $entityManager->flush();

//                 $this->addFlash('success', 'Votre compte a été supprimé avec succès.');

//                 return $this->redirectToRoute('app_home');
//             } else {
//                 $this->addFlash('error', 'Mot de passe incorrect.');
//             }
//         }

//         return $this->render('registration/editUser.html.twig', [
//             'ChangeEmailForm' => $changeEmailForm->createView(),
//             'ChangePasswordForm' => $changePasswordForm->createView(),
//             'DeleteAccountForm' => $deleteAccountForm->createView(),
//         ]);
//     }
// }
