<?php


namespace App\Conversation;


use BotMan\BotMan\Messages\Conversations\Conversation;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Outgoing\Question;

class OrderConversation extends Conversation
{

    /**
     * @return mixed
     */
    public function run()
    {
        $question = Question::create('Hoćeš li naručiti?')
            ->callbackId('order_start_selection')
            ->addButton(Button::create('Da!')->value('yes'));

        $this->ask($question, function (Answer $answer) {
            if ($answer->isInteractiveMessageReply()) {
                $this->say('Jebiga, još nisam implementiral!');
            }
        });
    }
}