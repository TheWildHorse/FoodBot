<?php


namespace App\Controller;


use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class FoodMenuController
 * @package App\Controller
 */
class FoodMenuController extends Controller
{
    /**
     * @Route("/food/menu", name="food.menu.full")
     * @param EntityManagerInterface $em
     * @return string
     */
    public function getFullMenu(EntityManagerInterface $em)
    {
        $repo = $em->getRepository('App:Restaraunt');
        $restaurants = $repo->findAll();

        return $this->render('foodMenu/full.html.twig', ['restaurants' => $restaurants]);
    }
}