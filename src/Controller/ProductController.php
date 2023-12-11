<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
/** contrôleur qui sert une page contenant la liste de tous les produits */

    #[Route(path: '/product/show-all', name: 'product_show_all')]
    public function showall(ProductRepository $productRepository){

        //il faut recuperer tous les produits de la base de donnees
        $products = $productRepository->findAll();

        //il faut construire une page HTML avec les produits recuperes

        //il faut retourner cette page
        return $this->render('base.html.twig',
        ['products'=> $products]);
    }
}