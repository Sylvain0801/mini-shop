<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryEditType;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('admin/category', name: 'admin_category_')]
class CategoryController extends AbstractController
{

    #[Route('/categories', name: 'categories')]
    public function categoryList(CategoryRepository $categoryRepository): Response
    {
        return $this->render('includes/_categories.html.twig', [
            'categories' => $categoryRepository->findAll(),
            'active' => 'user'
        ]);
    }

    #[Route('/list', name: 'list')]
    public function index(CategoryRepository $categoryRepository): Response
    {
        return $this->render('admin/category/index.html.twig', [
            'categories' => $categoryRepository->findAll(),
            'active' => 'user'
        ]);
    }

    #[Route('/new', name: 'new')]
    public function newCategory(Request $request): Response
    {
        $category = new Category();
        $form = $this->createForm(CategoryEditType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush();

            $this->addFlash('new_category', 'La catégorie a été créée avec succès');
            return $this->redirectToRoute('admin_category_list');
        }
        return $this->render('admin/category/new.html.twig', [
            'categoryForm' => $form->createView(),
            'active' => 'user'
            ]);
    }

    #[Route('/edit/{id}', name: 'edit')]
    public function editCategory(Category $category, Request $request): Response
    {
        $form = $this->createForm(CategoryEditType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush();

            $this->addFlash('modified_category', 'La catégorie a été modifiée avec succès');
            return $this->redirectToRoute('admin_category_list');
        }
        return $this->render('admin/category/edit.html.twig', [
            'categoryForm' => $form->createView(),
            'category' => $category,
            'active' => 'user'
            ]);
    }
        
    #[Route('/delete/{id}', name: 'delete')]
    public function delete(Category $category): RedirectResponse
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($category);
        $em->flush();
        
        $this->addFlash('delete_category', 'La catégorie a été supprimée avec succès');

    return $this->redirectToRoute('admin_category_list');
    }


}
