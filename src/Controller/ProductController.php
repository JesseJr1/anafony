<?php

namespace App\Controller;

use App\Entity\Review;
use App\Form\ReviewType;
use App\Repository\ProductRepository;
use App\Repository\ReviewRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
    public function details(ProductRepository $productRepository, string $id, Request $request, EntityManagerInterface $manager, ReviewRepository $reviewRepository): Response
    {
        $product = $productRepository->find($id);
        if (!$product) {
            // throw $this-> createNotFoundException();
        }
        $review = new Review;
        $reviewForm = $this->createForm(ReviewType::class, $review);
        $reviewForm->handleRequest($request);
        
        if ($reviewForm->isSubmitted() && $reviewForm->isValid()){
            $review->setProduct($product);
            /* $review->setContent($content); */
            /* $review->setEmail($email); */
            
            $manager->persist($review);
            $manager->flush();

            $this->addFlash('success', 'Votre message est bien envoyé!!!');
            return $this->redirectToRoute('app_product_detail'); 
            
        }
        return $this->render('product/detail.html.twig', [
            'product' => $product,
            'reviewForm' => $reviewForm->createView(),
            'product' => $reviewRepository->findBy(['product'=>$id])
        ]);

    }
}
