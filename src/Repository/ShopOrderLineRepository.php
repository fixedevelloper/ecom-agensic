<?php

namespace App\Repository;

use App\Entity\ShopOrderLine;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ShopOrderLine>
 *
 * @method ShopOrderLine|null find($id, $lockMode = null, $lockVersion = null)
 * @method ShopOrderLine|null findOneBy(array $criteria, array $orderBy = null)
 * @method ShopOrderLine[]    findAll()
 * @method ShopOrderLine[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ShopOrderLineRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ShopOrderLine::class);
    }

    public function save(ShopOrderLine $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(ShopOrderLine $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return ShopOrderLine[] Returns an array of ShopOrderLine objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?ShopOrderLine
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
