<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/product', name: 'product_')]
class ProductController extends AbstractController
{
    #[Route('/list', name: 'list')]
    public function index(ProductRepository $productRepository): Response
    {
        return $this->render('product/index.html.twig', [
            'products' => $productRepository->findBy(
                ['active' => true]
            )
        ]);
    }

    #[Route('/category/{name}/{id}', name: 'category')]
    public function productsByCategory($id, $name, ProductRepository $productRepository): Response
    {
        return $this->render('product/categoryfield.html.twig', [
            'products' => $productRepository->findBy(['category' => $id]),
            'category' => $name
        ]);
    }
}
