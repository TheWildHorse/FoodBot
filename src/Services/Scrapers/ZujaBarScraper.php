<?php


namespace App\Services\Scrapers;


use App\Entity\Food;
use App\Entity\Restaraunt;
use Goutte\Client;

class ZujaBarScraper implements MenuScraperInterface
{

    /**
     * @var Client
     */
    protected $gc;

    /**
     * ZujaBarImporter constructor.
     * @param Client $gc
     */
    public function __construct(Client $gc)
    {
        $this->gc = $gc;
    }

    /**
     * Fetches and returns daily Food objects for the restaurant
     * @return Food[]
     */
    public function fetchDailyFood(): array
    {
        // No daily menues
        return [];
    }

    /**
     * Fetches and returns regular Food objects for the restaurant
     * @return Food[]
     */
    public function fetchRegularFood(): array
    {
        $crawler = $this->gc->request('GET', 'http://zujabar.com/');
        $items = $crawler->filter('.menuEntry')->each(function ($node) {
            $food = new Food();
            $food->setIsDailyItem(false);
            $price = $node->filter('.itemPrice')->first()->text();
            $price = preg_replace('/[a-z ]/i', '', $price);
            $food->setPrice((float) $price);
            $food->setName($node->filter('.itemName')->first()->text());
            $food->setRestaurant($this->getRestaraunt());
            return $food;
        });

        return $items;
    }

    /**
     * @return Restaraunt
     */
    public function getRestaraunt(): Restaraunt
    {
        return (new Restaraunt())
            ->setName('Restoran Žuja Bar')
            ->setMinimumOrderAmount(100)
            ->setTelephone('00385981715938');
    }
}