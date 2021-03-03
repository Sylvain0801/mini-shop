<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
}
