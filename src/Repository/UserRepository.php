<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class UserRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * @param $orderId
     * @return User[]
     */
    public function getOrderParticipants($orderId) {
        return $this->createQueryBuilder('u')
            ->join('u.orderItems', 'i')
            ->where('i.order = :orderId')
            ->distinct()
            ->setParameter('orderId', $orderId)
            ->getQuery()
            ->getResult();
    }
}
