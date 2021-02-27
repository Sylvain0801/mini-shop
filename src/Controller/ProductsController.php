<?php

namespace App\Controller;

use App\Entity\Products;
use App\Form\ProductsType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductsController extends AbstractController
{
  /**
   * @Route("/products/new", name="new_product")
   * @return Response
   */
  public function new():Response
  {
    $product = new Products();
    $form = $this->createForm(ProductsType::class);
    return $this->render('products/new.html.twig', [
      "form" => $form->createView()
    ]);
  }
}