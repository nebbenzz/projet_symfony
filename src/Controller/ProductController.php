<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends AbstractController
{
/** contrôleur qui sert une page contenant la liste de tous les produits */

    #[Route('/product/show-all', name: 'product_show_all')]
    public function showall(ProductRepository $productRepository):Response{

        //il faut recuperer tous les produits de la base de donnees
        $products = $productRepository->findAll();

        //il faut construire une page HTML avec les produits recuperes

        //il faut retourner cette page
        return $this->render('product/product_show_all.html.twig',
        ['products'=> $products]);
    }

    /** contrôleur qui sert une page contenant la fiche d'un produit */
    #[Route('/product/show/{id}', name: 'product_show', requirements: ['id' =>'\d+'])]
    public function show(int $id, ProductRepository $productRepository):Response {

        //recuperation du produit dont l'id a été passé à notre contrôleur
        $product = $productRepository->find($id);

        if (null == $product){
            throw new NotFoundHttpException('Ce produit n\'existe pas');
        }

        //il faut construire la page html avec le produit recupere
        return $this->render('product/product_show.html.twig',
        ['product'=>$product]);
    }

    /**
     *recherche des produits à partir d'un mot clé
     */
    #[Route('/product/search', name:'product_search', methods: ['POST'])]
    public function search(Request $request, ProductRepository $productRepository):Response {
        $keywordSearched = $request->request->get('searchProduct');

        $productsWithDQL = $productRepository->searchWithDql($keywordSearched);
        $productsWithQB = $productRepository->searchWithQB($keywordSearched);

        return $this->render('product/product_show_all.html.twig', ['products'=>$productsWithQB]);

    }
}