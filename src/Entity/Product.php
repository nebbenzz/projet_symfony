<?php

namespace App\Entity;

class Product
{

    /** @var int|null numéro du produit */
    private ?int $id;

    /** @var string|null nom du produit */
    private ?string $name;

    /** description du produit */
    private ?string $description;

    /** date ajout au catalogue */
    private \DateTimeImmutable $createdAt;

    /** quantité en stock */
    private ?int $quantityInStock ;

    /** prix HT */
    private ?float $price;

    /** nom de l'image */
    private ?string $imageName;
}