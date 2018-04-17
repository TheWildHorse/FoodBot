<?php


namespace App\Controller\Api;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGenerator;
use Twilio\Rest\Client;

class OrderApiController extends Controller
{

    /**
     * @Route(path="/api/order/paid_status", methods={"POST"})
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function setOrderItemPaidStatus(Request $request) {
        $orderItemId = $request->get('orderItemId');
        $isPaid = $request->get('isPaid');

        $orderItem = $this->getDoctrine()
            ->getRepository('App:OrderItem')
            ->find($orderItemId);

        $orderItem->setIsPaid($isPaid);
        $this->get('doctrine.orm.default_entity_manager')->persist($orderItem);
        $this->get('doctrine.orm.default_entity_manager')->flush();

        return $this->json(['success' => 'true']);
    }

    /**
     * @Route(path="/api/order/ordered_status", methods={"POST"})
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function setOrderIsOrderedStatus(Request $request) {
        $orderId = $request->get('orderId');
        $isOrdered = $request->get('isOrdered');

        $order = $this->getDoctrine()
            ->getRepository('App:Order')
            ->find($orderId);

        $order->setIsOrdered($isOrdered);
        $this->get('doctrine.orm.default_entity_manager')->persist($order);
        $this->get('doctrine.orm.default_entity_manager')->flush();

        return $this->json(['success' => 'true']);
    }

    /**
     * @Route(path="/api/order/delivered_status", methods={"POST"})
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function setOrderIsDeliveredStatus(Request $request) {
        $orderId = $request->get('orderId');
        $isDelivered = $request->get('isDelivered');

        $order = $this->getDoctrine()
            ->getRepository('App:Order')
            ->find($orderId);

        $order->setIsDelivered($isDelivered);
        $this->get('doctrine.orm.default_entity_manager')->persist($order);
        $this->get('doctrine.orm.default_entity_manager')->flush();

        return $this->json(['success' => 'true']);
    }

    /**
     * @Route(path="/api/autoorder/{orderId}")
     * @param $orderId
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     * @throws \Twilio\Exceptions\ConfigurationException
     */
    public function autoOrder($orderId) {
        $sid = 'ACca0b5e6ae216a67c9e0377d8e391ee9b';
        $token = '317a0ac182ec3e94e1ab0125d01b8397';
        $client = new Client($sid, $token);

        $order = $this->getDoctrine()->getRepository('App:Order')->find($orderId);

        $call = $client->calls->create(
            $order->getRestaraunt()->getTelephone(), '+38531777139',
            [
                'url' => $this->get('router')->generate('voice.order_xml', ['orderId' => $orderId], UrlGenerator::ABSOLUTE_URL)
            ]
        );

        return $this->json(['call' => $call->sid]);
    }

}