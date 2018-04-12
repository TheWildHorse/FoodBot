<?php


namespace App\Controller;


use App\Conversation\OrderConversation;
use BotMan\BotMan\BotMan;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Outgoing\Question;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommunicationController extends Controller
{
    /**
     * @Route(path="/bot/order")
     * @param BotMan $botman
     * @return Response
     * @throws \InvalidArgumentException
     */
    public function orderingLogic(BotMan $botman) {
        $botman->hears('ola', function (BotMan $bot) {
            $bot->startConversation(new OrderConversation());
        });
        $botman->listen();

        return new Response();
    }
}