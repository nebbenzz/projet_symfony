<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

class ProductRepository extends ServiceEntityRepository
{

    private QueryBuilder $qb;

    private string $alias = 'pdt';

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }


    //**************************************************************
    // region *H1* Methodes retournant un QueryBuilder
    //**************************************************************


    //--------------------------------------------------------------
    //region **H2** Initialisation du queryBuilder
    //--------------------------------------------------------------

    /** Initialisation du queryBuilder courant de la variable qb*/
    private function initializeQueryBuilder():QueryBuilder{
        $this->qb = $this->createQueryBuilder($this->alias)
            ->select($this->alias);

        return $this->qb;
    }


    //--------------------------------------------------------------
    //endregion **H2** Initialisation du queryBuilder
    //--------------------------------------------------------------

    //--------------------------------------------------------------
    //region **H2** Filtres
    //--------------------------------------------------------------

    private function orNameLike(string $keyword):void {
        $this->qb->orWhere("$this->alias.name LIKE :name")
            ->setParameter('name', '%'.$keyword.'%');

    }

    private function orDescriptionLike(string $keyword):void {
        $this->qb->orWhere("$this->alias.description LIKE :description")
            ->setParameter('description', '%'.$keyword.'%');

    }

    private function orPropertyLike(string $propertyName, string $keyword):void{
        $this->qb->orWhere("$this->alias.$propertyName LIKE :$propertyName")
            ->setParameter($propertyName, '%'.$keyword.'%');
    }

    //--------------------------------------------------------------
    //endregion **H2** Filtres
    //--------------------------------------------------------------

    //**************************************************************
    //endregion *H1* Methodes retournant un QueryBuilder
    //**************************************************************

    public function search(string $keyword):array {
        $this->initializeQueryBuilder();
        //on recherche dans la description
        $this->orPropertyLike('description', $keyword);
        //on recherche dans le no du produit
        $this->orPropertyLike('name', $keyword);

        return $this->qb->getQuery()->getResult();
    }





}