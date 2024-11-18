<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Form\AdminUserUpdate;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Http\Attribute\IsGranted;


#[Route('admin/user')]
#[IsGranted('ROLE_ADMIN')]
class UpdateRoleUserController extends AbstractController
{
    #[Route('/', name: 'app_update_role_user_index', methods: ['GET'])]
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('admin/update_role_user/index.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }



    
    #[Route('/{id}', name: 'app_update_role_user_show', methods: ['GET'])]
    public function show(User $user): Response
    {
        return $this->render('admin/update_role_user/show.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_update_role_user_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(AdminUserUpdate::class, $user);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
    
            return $this->redirectToRoute('app_update_role_user_index', [], Response::HTTP_SEE_OTHER);
        }
    
        return $this->render('admin/update_role_user/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }
    
    #[Route('/{id}/delete', name: 'app_update_role_user_delete', methods: ['POST'])]
    public function remove(
        Request $request,
        int $id,
        UserRepository $userRepository,
        EntityManagerInterface $entityManager
    ): Response {
        $user = $userRepository->find($id);
    
        if (!$user) {
            $this->addFlash('danger', 'Utilisateur introuvable.');
            return $this->redirectToRoute('home');
        }
    
        if (!$this->isCsrfTokenValid('delete' . $user->getId(), $request->request->get('_token'))) {
            $this->addFlash('danger', 'Jeton CSRF invalide.');
            return $this->redirectToRoute('home');
        }
    
        $entityManager->remove($user);
        $entityManager->flush();
    
        $this->addFlash('success', 'Utilisateur supprimé avec succès.');
        return $this->redirectToRoute('home');
    }
    
}
