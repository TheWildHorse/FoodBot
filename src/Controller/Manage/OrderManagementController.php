<?php


namespace App\Controller\Manage;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class OrderManagementController extends Controller
{

    /**
     * @Route("/manage/orders")
     */
    public function getOrdersPanel()
    {
        $orders = $this->getDoctrine()
            ->getRepository('App:Order')
            ->getOrdersForDate(new \DateTime());
        return $this->render('manage/orders.html.twig', [
                'orders' => $orders
            ]);
    }

}