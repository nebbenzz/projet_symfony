<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\Type\ProductType;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ManageProductController extends AbstractController
{

    #[Route('manage/product/new', name: 'manage_product_new')]
    public function new(Request $request, EntityManagerInterface $em): Response
    {

        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);

        $form->add('Ajouter', SubmitType::class); //permet d'ajouter un champ à ceux prévus dans la classe ProductType

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //mise à jour de la date de création
            $product->setCreatedAt(new \DateTimeImmutable());


            //persister l'objet en bdd
            $em->persist($product);
            //synchronisation des objets persistés dans la bdd
            //pour faire simple, le produit est inséré dans la bdd
            $em->flush();

            $this->addFlash('success', 'Le produit a été ajouté au catalogue');

            $this->addFlash('error', 'Autre message de succès');

            $this->addFlash('notice', 'Autre message d\'information');

            $this->addFlash('notice', 'Autre message d\'information numéro 2');

            $this->addFlash('warning', 'Autre message d\'erreur');


            return $this->redirectToRoute('product_show_all');
        }
        return $this->render('product/product_new.html.twig', ['form' => $form->createView()]);

    }

    #[Route('manage/product/edit/{id}', name: 'manage_product_edit')]
    public function edit(Product $product, Request $request, EntityManagerInterface $em): Response
    {

        $form = $this->createForm(ProductType::class, $product);

        $form->add('updateProduct', SubmitType::class, ['label'=>'Modifier le produit', 'attr'=> ['class'=>'Button -no-danger -reverse']]); //permet d'ajouter un champ à ceux prévus dans la classe ProductType

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //mise à jour de la date de création
            $product->setCreatedAt(new \DateTimeImmutable());

            //synchronisation des objets persistés dans la bdd
            //pour faire simple, le produit est inséré dans la bdd
            $em->flush();

            $this->addFlash('success', 'Le produit a été mis à jour dans la bdd');

            return $this->redirectToRoute('product_show', ['id' => $product->getId()]);
        }

        return $this->render('product/product_new.html.twig', ['form' => $form,]);
    }
}