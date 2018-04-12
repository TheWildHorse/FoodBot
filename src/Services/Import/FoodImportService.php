<?php


namespace App\Services\Import;


use App\Entity\Food;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class FoodImportService
 * @package App\Services\Import
 */
class FoodImportService
{
    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * FoodImportService constructor.
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function deleteDailyFoods()
    {
        $this->em->getRepository('App:Food')
            ->createQueryBuilder('f')
            ->where('f.isDailyItem = 1')
            ->delete();
    }

    /**
     * @param array $foods
     * @throws \Exception
     */
    public function importFoods(array $foods)
    {
        foreach($foods as $food) {
            $this->importFood($food);
        }
    }

    /**
     * Imports a single food item for a restaraunt.
     * @param Food $food
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function importFood(Food $food)
    {
        if($food->getRestaurant() === null) {
            throw new \Exception('Food must be related to a restaraunt.');
        }
        $restaraunt = $this->em->getRepository('App:Restaraunt')
            ->findOneBy([
                'name' => $food->getRestaurant()->getName()
            ]);
        if($restaraunt !== null) {
            $food->setRestaurant($restaraunt);
            if($this->em->getRepository('App:Food')->findOneBy(['name' => $food->getName(), 'restaurant' => $restaraunt]) !== null) {
                return;
            }
        }

        $this->em->persist($food->getRestaurant());
        $this->em->persist($food);
        $this->em->flush();
    }

}