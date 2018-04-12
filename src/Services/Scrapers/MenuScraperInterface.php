<?php


namespace App\Services\Scrapers;


use App\Entity\Food;
use App\Entity\Restaraunt;

interface MenuScraperInterface
{
    public function getRestaraunt(): Restaraunt;

    /**
     * Fetches and returns daily Food objects for the restaurant
     * @return Food[]
     */
    public function fetchDailyFood(): array;

    /**
     * Fetches and returns regular Food objects for the restaurant
     * @return Food[]
     */
    public function fetchRegularFood(): array;

}