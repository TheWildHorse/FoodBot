<?php


namespace App\Services\Importers;


use App\Entity\Food;
use Goutte\Client;

class FontanaCrnkovicImporter implements MenuImporterInterface
{

    /**
     * @var Client
     */
    protected $gc;

    /**
     * FontanaCrnkovicImporter constructor.
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
        $crawler = $this->gc->request('GET', 'http://fontana-gableci.com/');
        $items = $crawler->filter('.menu-category .menu-item')->each(function ($node) {
             $food = new Food();
             $food->setIsDailyItem(true);
             $price = $node->filter('.amount')->first()->text();
             $price = preg_replace('/[a-z ]/i', '', $price);
             $food->setPrice((float) $price);
             $food->setName(ucfirst(mb_strtolower($node->filter('h6 > a')->first()->text())));
             return $food;
        });

        return $items;
    }

    /**
     * Fetches and returns regular Food objects for the restaurant
     * @return Food[]
     */
    public function fetchRegularFood(): array
    {
        // Only daily menus available
        return [];
    }
}