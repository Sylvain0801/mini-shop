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

    #[Route('/user/list', name: 'user_list')]
    public function usersList(UserRepository $userRepository): Response
    {
        return $this->render('admin/user/userslist.html.twig', [
            'users' => $userRepository->findAll()
        ]);
    }

    #[Route('/user/edit/{id}', name: 'user_edit')]
    public function editUser(User $user, Request $request): Response
    {
        $form = $this->createForm(UserEditType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $this->addFlash('message_user_admin', 'L\'utilisateur a été modifié avec succès');
            return $this->redirectToRoute('admin_user_list');
        }
        return $this->render('admin/user/edituser.html.twig', [
            'userEditForm' => $form->createView()
            ]);
        }
        
    #[Route('/user/delete/{id}', name: 'user_delete')]
    public function delete(User $user): RedirectResponse
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($user);
        $em->flush();
        
        $this->addFlash('message_user_admin', 'L\'utilisateur a été supprimé avec succès');

    return $this->redirectToRoute('admin_user_list');
    }


}
