<?php


namespace App\Services\Importers;


use App\Entity\Food;

interface MenuImporterInterface
{
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