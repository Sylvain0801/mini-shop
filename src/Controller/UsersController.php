<?php

namespace App\Controller;

use App\Entity\Users;
use App\Form\UsersConnectType;
use App\Form\UsersType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UsersController extends AbstractController
{
    /**
     * @Route("/users/home", name="users_home")
     */
    public function index(): Response
    {
        return $this->render('users/index.html.twig');
    }

    /**
     * @Route("/users/inscription", name="users_inscription")
     */
    public function inscription(): Response
    {
        $product = new Users();
        $form = $this->createForm(UsersType::class);

        return $this->render('users/inscription.html.twig', [
          "form" => $form->createView()
        ]);
    }

    /**
     * @Route("/users/connexion", name="users_connexion")
     */
    public function connexion(): Response
    {
        $product = new Users();
        $form = $this->createForm(UsersConnectType::class);

        return $this->render('users/connexion.html.twig', [
          "form" => $form->createView()
        ]);
    }
}
