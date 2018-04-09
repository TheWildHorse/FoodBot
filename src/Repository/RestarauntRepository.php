<?php

namespace App\Repository;

use App\Entity\Restaraunt;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Restaraunt|null find($id, $lockMode = null, $lockVersion = null)
 * @method Restaraunt|null findOneBy(array $criteria, array $orderBy = null)
 * @method Restaraunt[]    findAll()
 * @method Restaraunt[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RestarauntRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Restaraunt::class);
    }

//    /**
//     * @return Restaraunt[] Returns an array of Restaraunt objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Restaraunt
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
