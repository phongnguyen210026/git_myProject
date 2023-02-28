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
   public function checkProductInCart($user_id, $p_id, $size): array
   {
       return $this->createQueryBuilder('c')
           ->where('c.user = :value')
           ->setParameter('value', $user_id)
           ->andWhere('c.product = :val')
           ->setParameter('val', $p_id)
           ->andWhere('c.size = :va')
           ->setParameter('va', $size)
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
   public function findProductInCart($user_id): array
   {
       return $this->createQueryBuilder('c')
           ->select('c.id, c.product_count, c.size, p.product_name, p.image, (p.price * c.product_count) as total, cat.category_name')
           ->innerJoin('c.product', 'p')
           ->innerJoin('p.cat', 'cat')
           ->where('c.user = :val')
           ->setParameter('val', $user_id)
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
   public function countProductInCart($id): array
   {
       return $this->createQueryBuilder('c')
           ->select('count(c.user) as count')
           ->where('c.user = :val')
           ->setParameter('val', $id)
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

   /**
    * @return Cart[] Returns an array of Cart objects
    */
   public function deleteCart($user_id)
   {
       $en = $this->getEntityManager()->getConnection();
       $sql = 'delete from cart where user_id = :val';
       $stmt = $en->prepare($sql);
       $stmt->executeQuery(['val'=>$user_id]);
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
