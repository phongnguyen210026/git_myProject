<?php

namespace App\Repository;

use App\Entity\Cart;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Cart>
 *
 * @method Cart|null find($id, $lockMode = null, $lockVersion = null)
 * @method Cart|null findOneBy(array $criteria, array $orderBy = null)
 * @method Cart[]    findAll()
 * @method Cart[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CartRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Cart::class);
    }

    public function save(Cart $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Cart $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

   /**
    * @return Cart[] Returns an array of Cart objects
    */
   public function checkProductInCart($user_id, $p_id): array
   {
       return $this->createQueryBuilder('c')
           ->where('c.user = :value')
           ->setParameter('value', $user_id)
           ->andWhere('c.product = :val')
           ->setParameter('val', $p_id)
           ->getQuery()
           ->getArrayResult()
       ;
   }

   /**
    * @return Cart[] Returns an array of Cart objects
    */
   public function findProductCount($user_id, $p_id): array
   {
       return $this->createQueryBuilder('c')
           ->select('c.product_count')
           ->where('c.user = :value')
           ->setParameter('value', $user_id)
           ->andWhere('c.product = :val')
           ->setParameter('val', $p_id)
           ->getQuery()
           ->getArrayResult()
       ;
   }

   /**
    * @return Cart[] Returns an array of Cart objects
    */
   public function findProductInCart(): array
   {
       return $this->createQueryBuilder('c')
           ->select('c.id, c.product_count, c.size, p.product_name, p.image, (p.price * c.product_count) as total, cat.category_name')
           ->innerJoin('c.product', 'p')
           ->innerJoin('p.cat', 'cat')
           ->getQuery()
           ->getArrayResult()
       ;
   }

   /**
    * @return Cart[] Returns an array of Cart objects
    */
   public function findPrice(): array
   {
       return $this->createQueryBuilder('c')
           ->select('(p.price * c.product_count) as total')
           ->innerJoin('c.product', 'p')
           ->getQuery()
           ->getArrayResult()
       ;
   }

   /**
    * @return Cart[] Returns an array of Cart objects
    */
   public function countProductInCart(): array
   {
       return $this->createQueryBuilder('c')
           ->select('count(c.user) as count')
           ->getQuery()
           ->getArrayResult()
       ;
   }

   /**
    * @return Cart[] Returns an array of Cart objects
    */
   public function findCartByUId($value): array
   {
       return $this->createQueryBuilder('c')
           ->select('c.id, c.product_count, identity(c.user) user, identity(c.product) product, c.size')
           ->Where('c.user = :val')
           ->setParameter('val', $value)
           ->getQuery()
           ->getArrayResult()
       ;
   }

//    /**
//     * @return Cart[] Returns an array of Cart objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Cart
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
