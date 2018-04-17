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

    public function getGroupedOrderItems($orderId) {
        $q = $this
            ->createQueryBuilder('i')
            ->select('f.name as name, COUNT(i) as count')
            ->join('i.food', 'f')
            ->where('i.order = :orderId')
            ->groupBy('i.id')
            ->setParameter('orderId', $orderId)
            ->getQuery();

        return $q->getResult();
    }

}
