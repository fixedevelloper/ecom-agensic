<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Product>
 *
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    public function save(Product $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Product $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @param $max
     * @return Product[] Returns an array of Product objects
     */
    public function findByBestseller($max): array
    {
        return $this->createQueryBuilder('p')
            ->orderBy('p.id', 'DESC')
            ->setMaxResults($max)
            ->getQuery()
            ->getResult()
        ;
    }
    /**
     * @param $max
     * @return Product[] Returns an array of Product objects
     */
    public function findPopularproducts($max): array
    {
        return $this->createQueryBuilder('p')
            ->orderBy('p.id', 'DESC')
            ->setMaxResults($max)
            ->getQuery()
            ->getResult()
            ;
    }
    /**
     * @param $max
     * @return Product[] Returns an array of Product objects
     */
    public function findNewArrivals($max): array
    {
        return $this->createQueryBuilder('p')
            ->orderBy('p.id', 'DESC')
            ->setMaxResults($max)
            ->getQuery()
            ->getResult()
            ;
    }
    /**
     * @param $max
     * @return Product[] Returns an array of Product objects
     */
    public function findFeatureds($max): array
    {
        return $this->createQueryBuilder('p')
            ->orderBy('p.id', 'DESC')
            ->setMaxResults($max)
            ->getQuery()
            ->getResult()
            ;
    }
    /**
     * @param $max
     * @return Product[] Returns an array of Product objects
     */
    public function findCategories($max): array
    {
        return $this->createQueryBuilder('p')
            ->orderBy('p.id', 'DESC')
            ->setMaxResults($max)
            ->getQuery()
            ->getResult()
            ;
    }

//    public function findOneBySomeField($value): ?Product
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
