<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

class ProductRepository extends ServiceEntityRepository
{

    private QueryBuilder $qb;
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    public function searchWithDql(string $keyword): array {
        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery(
            '
                SELECT p
                FROM App\Entity\Product p
                WHERE p.name LIKE :name
                '
        )
        ->setParameter('name', '%'.$keyword.'%');

        return $query->execute(); //tableau d'objet
    }

    public function searchWithQB(string $keyword): array {
        //construction de la requête
        $this->qb = $this->createQueryBuilder('p')
            ->where('p.name LIKE :name')
            ->setParameter('name', '%'.$keyword.'%');

        $this->filterDescription($keyword);
        return $this->qb->getQuery()->getResult(); //tableau d'objets
    }

    public function filterDescription(string $keyword){
        $this->qb->orWhere('p.description LIKE :name')
            ->setParameter('name','%'.$keyword.'%');
        return $this->qb;
    }
}