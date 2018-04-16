<?php

namespace App\Repository;

use App\Entity\Order;
use App\Entity\Restaraunt;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Order|null find($id, $lockMode = null, $lockVersion = null)
 * @method Order|null findOneBy(array $criteria, array $orderBy = null)
 * @method Order[]    findAll()
 * @method Order[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrderRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Order::class);
    }

    /**
     * @param Restaraunt $restaraunt
     * @return Order
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function getOrCreateOrder(Restaraunt $restaraunt): Order {
        $fromDate = new \DateTime('now');
        $fromDate->setTime(0, 0, 0);
        $toDate = clone $fromDate;
        $toDate->modify('+1 day');

        $q = $this
            ->createQueryBuilder('o')
            ->where('o.endTime >= :fromDate')
            ->andWhere('o.endTime < :toDate')
            ->andWhere('o.restaraunt = :restaurant')
            ->setParameter('fromDate', $fromDate)
            ->setParameter('toDate', $toDate)
            ->setParameter('restaurant', $restaraunt)
            ->getQuery();

        $order = $q->getOneOrNullResult();
        if($order === null) {
            $order = new Order();
            $order->setRestaraunt($restaraunt);
            $order->setEndTime(new \DateTime());
            $order->setIsDelivered(false);
            $order->setAutoorder(true);
            $order->setIsOrdered(false);
            $this->getEntityManager()->persist($order);
            $this->getEntityManager()->flush();
        }

        return $order;
    }

//    /**
//     * @return Order[] Returns an array of Order objects
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
    public function findOneBySomeField($value): ?Order
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
