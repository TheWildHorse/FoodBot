<?php

namespace App\Repository;

use App\Entity\OrderItem;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method OrderItem|null find($id, $lockMode = null, $lockVersion = null)
 * @method OrderItem|null findOneBy(array $criteria, array $orderBy = null)
 * @method OrderItem[]    findAll()
 * @method OrderItem[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrderItemRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, OrderItem::class);
    }

    public function getTodaysOrderItemsForUser(User $user)
    {
        $fromDate = new \DateTime('now');
        $fromDate->setTime(0, 0, 0);
        $toDate = clone $fromDate;
        $toDate->modify('+1 day');

        return $this
            ->createQueryBuilder('o')
            ->where('o.date >= :fromDate')
            ->andWhere('o.date < :toDate')
            ->andWhere('o.user = :user')
            ->setParameter('fromDate', $fromDate)
            ->setParameter('toDate', $toDate)
            ->setParameter('user', $user)
            ->getQuery()
            ->getResult();
    }

//    /**
//     * @return OrderItem[] Returns an array of OrderItem objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('o.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?OrderItem
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
