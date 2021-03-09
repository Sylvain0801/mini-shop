<?php

namespace App\Controller;

use App\Entity\Product;
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
                ['active' => true]),
                'title' => 'Tous nos produits design'
        ]);
    }

    #[Route('/favourite', name: 'favourite')]
    public function favouriteList(): Response
    {
        $favouritelist = $this->getUser()->getMyproducts();
        return $this->render('product/index.html.twig', [
            'products' => $favouritelist,
            'title' => 'Mes produits favoris'
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

    #[Route('/favourite/add/{id}', name: 'favourite_add')]
    public function addFavourites(Product $product): Response
    {
        $product->addFavourite($this->getUser());

        $em = $this->getDoctrine()->getManager();
        $em->persist($product);
        $em->flush();

        return new Response('true');
    }

    #[Route('/favourite/remove/{id}', name: 'favourite_remove')]
    public function removeFavourites(Product $product): Response
    {
        $product->removeFavourite($this->getUser());

        $em = $this->getDoctrine()->getManager();
        $em->persist($product);
        $em->flush();
        
        return new Response('true');
    }
}
