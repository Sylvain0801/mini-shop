<?php

namespace App\Controller\Admin;

use App\Entity\Product;
use App\Form\ProductType;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('admin/product', name: 'admin_product_')]
class ProductController extends AbstractController
{
    #[Route('/list', name: 'list')]
    public function index(ProductRepository $productRepository): Response
    {   
        return $this->render('admin/product/index.html.twig', [
            'products' => $productRepository->findAll()
        ]);
    }

    #[Route('/new', name: 'new')]
    public function newProduct(Request $request): Response
    {
        $product = new Product();
        $product->setCreatedBy($this->getUser());
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($product);
            $em->flush();

            $this->addFlash('product', 'Le produit a été créé avec succès');
            return $this->redirectToRoute('admin_product_list');
        }
        return $this->render('admin/product/new.html.twig', [
            'productForm' => $form->createView()
            ]);
    }

    #[Route('/edit/{slug}', name: 'edit')]
    public function editProduct($slug, Request $request, ProductRepository $productRepository): Response
    {

        $product = $productRepository->findOneBy(['slug' => $slug]);
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($product);
            $em->flush();

            $this->addFlash('product', 'Le produit a été modifié avec succès');
            return $this->redirectToRoute('admin_product_list');
        }
        return $this->render('admin/product/edit.html.twig', [
            'productForm' => $form->createView(),
            'product' => $product
            ]);
    }

    #[Route('/delete/{id}', name: 'delete')]
    public function delete(Product $product): RedirectResponse
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($product);
        $em->flush();
        
        $this->addFlash('product', 'La catégorie a été supprimée avec succès');
        
        return $this->redirectToRoute('admin_product_list');
    }
    
    #[Route('/active/{id}', name: 'active')]
    public function activer(Product $product)
    {
        $product->setActive( $product->getActive() ? false : true );

        $em = $this->getDoctrine()->getManager();
        $em->persist($product);
        $em->flush();

        return new Response("true");

    }

    #[Route('/firstpage/{id}', name: 'firstpage')]
    public function firstpage(Product $product)
    {
        $product->setFirstpage( $product->getFirstpage() ? false : true );

        $em = $this->getDoctrine()->getManager();
        $em->persist($product);
        $em->flush();

        return new Response("true");

    }
}
