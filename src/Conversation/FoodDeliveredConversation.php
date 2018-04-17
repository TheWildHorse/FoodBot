<?php


namespace App\Conversation;


use App\Entity\OrderItem;
use App\Entity\Restaraunt;
use App\Helper\MarkdownTableHelper;
use App\Services\Communication\ContainerAwareConversationTrait;
use App\Services\GiphyService;
use BotMan\BotMan\Messages\Attachments\Image;
use BotMan\BotMan\Messages\Conversations\Conversation;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Outgoing\OutgoingMessage;
use BotMan\BotMan\Messages\Outgoing\Question;
use BotMan\Drivers\Slack\Extensions\Menu;

class FoodDeliveredConversation extends Conversation
{
    use ContainerAwareConversationTrait;

    /**
     * @return mixed
     */
    public function run()
    {
        $gifUrl = $this->container->get(GiphyService::class)->getRandomGifForTag('food');
        $this->say('Hrana je stigla! ', [
            'attachments' => json_encode([['title' => 'Food!', 'image_url' => $gifUrl]])
        ]);
    }
}