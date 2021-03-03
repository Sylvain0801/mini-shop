<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('admin/product', name: 'admin_product_')]
class ProductController extends AbstractController
{
    #[Route('/list', name: 'list')]
    public function index(): Response
    {
        return $this->render('admin/product/index.html.twig');
    }

    #[Route('/new', name: 'new')]
    public function newProduct(Request $request): Response
    {
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($product);
            $em->flush();

            $this->addFlash('new_product', 'Le produit a été créé avec succès');
            return $this->redirectToRoute('admin_product_list');
        }
        return $this->render('admin/product/new.html.twig', [
            'productForm' => $form->createView()
            ]);
    }
}
