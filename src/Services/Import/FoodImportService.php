<?php


namespace App\Services\Import;


use App\Entity\Food;
use App\Services\NLP\KeywordProcessingService;
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
     * @var KeywordProcessingService
     */
    protected $kps;

    /**
     * FoodImportService constructor.
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em, KeywordProcessingService $kps)
    {
        $this->em = $em;
        $this->kps = $kps;
    }

    public function deleteDailyFoods()
    {
        $this->em->getRepository('App:Food')
            ->createQueryBuilder('f')
            ->where('f.isDailyItem = 1')
            ->delete()
            ->getQuery()
            ->execute();
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
     * @throws \Exception
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

        $food->setKeywordText(implode(' ', $this->kps->getKeywordsFromText($food->getName())));

        $this->em->persist($food->getRestaurant());
        $this->em->persist($food);
        $this->em->flush();
    }

}