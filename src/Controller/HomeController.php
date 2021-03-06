<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
  /**
   * @Route("/", name="home")
   * @return Response
   */
  public function home(ProductRepository $productRepository):Response
  {
    return $this->render('index.html.twig', [
      'products' => $productRepository->findBy(
        ['firstpage' => true, 'active' => true],
        ['price' => 'ASC']
      )
  ]);
  }
}
