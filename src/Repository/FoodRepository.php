<?php

namespace App\Repository;

use App\Entity\Food;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Food|null find($id, $lockMode = null, $lockVersion = null)
 * @method Food|null findOneBy(array $criteria, array $orderBy = null)
 * @method Food[]    findAll()
 * @method Food[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FoodRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Food::class);
    }

    /**
     * Returns foods that match the keywords
     * @param $keywords
     * @return mixed
     */
    public function getFoodsByKeywords($keywords)
    {
        $q = $this->createQueryBuilder('f')
            ->where('f.keywordText = \''. implode(' ',$keywords). '\'');
        foreach($keywords as $keyword) {
            $q->orWhere('f.keywordText LIKE \'%'.trim($keyword, ',.;!? ').'%\'');
        }

        return $q->getQuery()
            ->getResult();
    }

//    /**
//     * @return Food[] Returns an array of Food objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Food
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
