<?php


namespace App\Controller;


use App\Conversation\InitiateOrderConversation;
use BotMan\BotMan\BotMan;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Outgoing\Question;
use Psr\Container\ContainerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommunicationController extends Controller
{
    /**
     * @Route(path="/bot/order")
     * @param BotMan $botman
     * @return Response
     */
    public function orderingLogic(BotMan $botman) {
        $botman->hears('ola', function (BotMan $bot) {
            $bot->reply('
            Dobro jutro ' . $bot->getUser()->getUsername() . '!');
            $bot->startConversation($this->get(InitiateOrderConversation::class));
        });
        $botman->listen();

        return new Response();
    }
}