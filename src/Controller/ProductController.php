<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    #[Route('/produits', name: 'app_products')]
    public function list(ProductRepository $productRepository): Response
    {
        return $this->render('product/listProduct.html.twig', [
            'products' => $productRepository->findAll(),
        ]);
    }

    #[Route('/produit{id<\d+>}', name: 'app_product')]
    public function show(string $id, ProductRepository $productRepository)
    {
        return $this->render('product/show.html.twig', [
            'product' => $productRepository->find($id),
        ]);
    }

    #[Route('/produits{id<\d+>}', name: 'app_product_detail')]
    public function detail(string $id, ProductRepository $productRepository)
    {
        return $this->render('product/detail.html.twig', [
            'product_detail' => $productRepository->find($id),
        ]);
    }
}
