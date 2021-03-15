<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
* @Route("/product", name="product_")
*/
class ProductController extends AbstractController
{
    /**
    * @Route("/list", name="list")
    * @return Response
    */
    public function index(ProductRepository $productRepository)
    {
        return $this->render('product/index.html.twig', [
            'products' => $productRepository->findBy(
                ['active' => true]),
                'title' => 'Tous nos produits design',
                'active' => 'product'
        ]);
    }

    /**
    * @Route("/favourite", name="favourite")
    * @return Response
    */
    public function favouriteList(): Response
    {
        $favouritelist = $this->getUser()->getMyproducts();
        return $this->render('product/index.html.twig', [
            'products' => $favouritelist,
            'title' => 'Mes produits favoris',
            'active' => 'product'
        ]);
    }

    /**
    * @Route("/category/{name}/{id}", name="category")
    * @return Response
    */
    public function productsByCategory($id, $name, ProductRepository $productRepository): Response
    {
        return $this->render('product/categoryfield.html.twig', [
            'products' => $productRepository->findBy(['category' => $id]),
            'category' => $name,
            'active' => 'product'
        ]);
    }
    
    /**
    * @Route("/favourite/add/{id}", name="favourite_add")
    * @return Response
    */
    public function addFavourites(Product $product): Response
    {
        $product->addFavourite($this->getUser());

        $em = $this->getDoctrine()->getManager();
        $em->persist($product);
        $em->flush();

        return new Response('true');
    }
    
    /**
    * @Route("/favourite/remove/{id}", name="favourite_remove")
    * @return Response
    */
    public function removeFavourites(Product $product): Response
    {
        $product->removeFavourite($this->getUser());

        $em = $this->getDoctrine()->getManager();
        $em->persist($product);
        $em->flush();
        
        return new Response('true');
    }
}
