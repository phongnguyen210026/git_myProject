<?php

namespace App\Repository;

use App\Entity\OrderDetail;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<OrderDetail>
 *
 * @method OrderDetail|null find($id, $lockMode = null, $lockVersion = null)
 * @method OrderDetail|null findOneBy(array $criteria, array $orderBy = null)
 * @method OrderDetail[]    findAll()
 * @method OrderDetail[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrderDetailRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OrderDetail::class);
    }

    public function save(OrderDetail $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(OrderDetail $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

   /**
    * @return OrderDetail[] Returns an array of OrderDetail objects
    */
   public function showDetail($date): array
   {
       return $this->createQueryBuilder('od')
           ->select('o.date, p.id, od.product_quantity, p.product_name, p.price, p.image')
           ->innerJoin('od.od', 'o')
           ->innerJoin('od.products', 'p')
           ->where('o.date = :val')
           ->setParameter('val', $date)
           ->getQuery()
           ->getArrayResult()
       ;
   }

   /**
    * @return OrderDetail[] Returns an array of OrderDetail objects
    */
   public function countItemOrder($value): array
   {
       return $this->createQueryBuilder('od')
           ->innerJoin('od.od', 'o')
           ->select('count(o.id) as count')
           ->Where('o.date = :val')
           ->setParameter('val', $value)
           ->getQuery()
           ->getArrayResult()
       ;
   }

   /**
    * @return OrderDetail[] Returns an array of OrderDetail objects
    */
   public function findProductHistory($value): array
   {
       return $this->createQueryBuilder('od')
           ->select('p.image, p.product_name, od.product_quantity')
           ->innerJoin('od.products', 'p')
           ->innerJoin('od.od', 'o')
           ->where('o.users = :val')
           ->setParameter('val', $value)
           ->getQuery()
           ->getArrayResult()
       ;
   }

//    /**
//     * @return OrderDetail[] Returns an array of OrderDetail objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('o')
//            ->andWhere('o.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('o.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?OrderDetail
//    {
//        return $this->createQueryBuilder('o')
//            ->andWhere('o.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
