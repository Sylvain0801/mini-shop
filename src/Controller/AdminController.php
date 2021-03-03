<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserEditType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin', name: 'admin_')]
class AdminController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(): Response
    {
        return $this->render('admin/index.html.twig');
    }

    #[Route('/liste-users', name: 'liste_users')]
    public function usersList(UserRepository $userRepository): Response
    {
        return $this->render('admin/userslist.html.twig', [
            'users' => $userRepository->findAll()
        ]);
    }

    #[Route('/edit-user/{id}', name: 'edit_user')]
    public function editUser(User $user, Request $request): Response
    {
        $form = $this->createForm(UserEditType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $this->addFlash('modified_user', 'L\'utilisateur a été modifié avec succès');
            return $this->redirectToRoute('admin_liste_users');
        }
        return $this->render('admin/edituser.html.twig', [
            'userEditForm' => $form->createView()
            ]);
        }
        
        #[Route('/delete-user/{id}', name: 'delete_user')]
        public function delete(User $user): RedirectResponse
        {
            $em = $this->getDoctrine()->getManager();
            $em->remove($user);
            $em->flush();
            
            $this->addFlash('delete_user', 'L\'utilisateur a été supprimé avec succès');

        return $this->redirectToRoute('admin_liste_users');
    }


}
