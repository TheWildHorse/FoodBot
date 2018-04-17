<?php


namespace App\Controller;



use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twilio\Twiml;

class VoiceCommunicationController extends Controller
{

    /**
     * @Route(path="/voice/order/{orderId}", name="voice.order_xml")
     * @param $orderId
     * @return Response
     * @throws \Twilio\Exceptions\TwimlException
     */
    public function getCallXMLForOrder(Request $request, $orderId) {
        $orderItems = $this->getDoctrine()
            ->getRepository('App:OrderItem')
            ->getGroupedOrderItems($orderId);
        $text = 'Dobar dan, ovo je automatska narudžba iz poduzeća EKSA-JO. Nalazimo se u Međimurskoj ulici 28 u Varaždinu. Željeli bi naručiti ';
        foreach($orderItems as $orderItem) {
            $text .= $orderItem['count'] . ' puta ' . $orderItem['name'] . ',';
        }
        $text .= '. Ukoliko ste uspješno zaprimili narudžbu poklopite slušalicu. Ukoliko se želite spojiti s naručiocem pričekajte na liniji.';

        $response = new Twiml();
        $wavDir = $this->get('kernel')->getRootDir().'/../public/voice-files/'.$orderId.'.wav';
        shell_exec('espeak -vhr -s 120 -p 70 -w ' . $wavDir . ' "' . $text . '"');
        $baseurl = $request->getScheme() . '://' . $request->getHttpHost() . $request->getBasePath();
        $response->play($baseurl . '/voice-files/'.$orderId.'.wav', $packageName = null);
        $response->pause(['length' => 5]);
        $dial = $response->dial();
        $dial->number('+385981715938');

        return new Response($response, 200, ['Content-Type' => 'text/xml']);
    }

}