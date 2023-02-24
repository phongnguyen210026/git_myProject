<?php

namespace App\Repository;

use App\Entity\ProductDetail;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ProductDetail>
 *
 * @method ProductDetail|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProductDetail|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProductDetail[]    findAll()
 * @method ProductDetail[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductDetailRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProductDetail::class);
    }

    public function save(ProductDetail $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(ProductDetail $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

   /**
    * @return ProductDetail[] Returns an array of ProductDetail objects
    */
   public function showProductDetail(): array
   {
       return $this->createQueryBuilder('pd')
           ->select('pd.id, p.product_name, pd.size, pd.stock, pd.status')
           ->innerJoin('pd.product', 'p')
           ->getQuery()
           ->getArrayResult()
       ;
   }

//    /**
//     * @return ProductDetail[] Returns an array of ProductDetail objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?ProductDetail
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
