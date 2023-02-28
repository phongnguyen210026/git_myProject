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
    * @return Product[] Returns an array of Product objects
    */
   public function searchProduct($ps): array
   {
       return $this->createQueryBuilder('p')
           ->Where('p.product_name LIKE :val')
           ->setParameter('val', '%'.$ps.'%')
           ->getQuery()
           ->getArrayResult()
       ;
   }

   /**
    * @return Product[] Returns an array of Product objects
    */
   public function findId(): array
   {
       return $this->createQueryBuilder('p')
           ->select('p.id')
           ->innerJoin('p.carts', 'c')
           ->getQuery()
           ->getArrayResult()
       ;
   }   

   /**
    * @return Product[] Returns an array of Product objects
    */
   public function findProductByBrandMen($value): array
   {
       return $this->createQueryBuilder('p')
           ->select('p.id, p.product_name, p.price, p.image')
           ->innerJoin('p.cat', 'c')
           ->Where('c.category_parent = :val')
           ->setParameter('val', 'men')
           ->andWhere('p.brand = :value')
           ->setParameter('value', $value)
           ->getQuery()
           ->getArrayResult()
       ;
   }

   /**
    * @return Product[] Returns an array of Product objects
    */
    public function findProductByBrandWomen($value): array
    {
        return $this->createQueryBuilder('p')
            ->select('p.id, p.product_name, p.price, p.image')
            ->innerJoin('p.cat', 'c')
            ->Where('c.category_parent = :val')
            ->setParameter('val', 'women')
            ->andWhere('p.brand = :value')
            ->setParameter('value', $value)
            ->getQuery()
            ->getArrayResult()
        ;
    }

//    /**
//     * @return Product[] Returns an array of Product objects
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
