<?php


namespace App\Conversation;


use App\Entity\Restaraunt;
use App\Helper\MarkdownTableHelper;
use App\Services\Communication\ContainerAwareConversationTrait;
use BotMan\BotMan\Messages\Conversations\Conversation;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Outgoing\OutgoingMessage;
use BotMan\BotMan\Messages\Outgoing\Question;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class InitiateOrderConversation extends Conversation
{
    use ContainerAwareConversationTrait;

    /**
     * @return mixed
     */
    public function run()
    {
        $em = $this->container->get('doctrine.orm.default_entity_manager');
        $user = $em->getRepository('App:User')
            ->findOneBy(['slackId' => $this->getBot()->getUser()->getId()]);
        if($user === null || empty($user->getFavourites())) {
            $this->getBot()->startConversation(
                $this->container->get(FavouritesConversation::class)
            );
            return;
        }

        $question = Question::create('Hoćeš li naručiti?')
            ->callbackId('order_start_selection')
            ->addButton(Button::create('Da!')->value('yes'));

        $this->ask($question, function (Answer $answer) {
            if ($answer->isInteractiveMessageReply()) {
                $this->sendDailyMenu();
            }
        });
    }

    /**
     * @return \App\Entity\User|null|object
     */
    public function getUser()
    {
        $em = $this->container->get('doctrine.orm.default_entity_manager');
        return $em->getRepository('App:User')->findOneBy(['slackId' => $this->getBot()->getUser()->getId()]);
    }

    public function sendDailyMenu()
    {
        $fullMenuLink = $this->container->get('router')->generate('food.menu.full', [], UrlGeneratorInterface::ABSOLUTE_URL);
        $dailyFavourites = $this->getDailyFavourites();
        if($dailyFavourites === null) {
            $this->say(
                'Ništa od navedenog ti se ne jede? Nema problema - pogledaj cijelu ponudu ovdje: '.$fullMenuLink . PHP_EOL . '*Današnja dnevna ponuda:*',
                ['attachments' => json_encode($this->getDailyMenuAttachments())]
            );
        }
        else {
            $this->say(
                'Ništa od navedenog ti se ne jede? Nema problema - pogledaj cijelu ponudu ovdje: '.$fullMenuLink . PHP_EOL . '*Današnja dnevna ponuda:*',
                ['attachments' => json_encode($dailyFavourites)]
            );
        }
        $this->getBot()->startConversation(
            $this->container->get(OrderConversation::class)
        );
    }

    protected function getDailyFavourites()
    {
        $fullMenuLink = $this->container->get('router')->generate('food.menu.full', [], UrlGeneratorInterface::ABSOLUTE_URL);
        $foods = $this->container->get('doctrine.orm.default_entity_manager')
            ->getRepository('App:Food')
            ->getFoodsByKeywords($this->getUser()->getFavourites());
        if(empty($foods)) {
            return null;
        }

        $attachments = [];
        $names = [];
        $prices = [];
        foreach($foods as $food) {
            if($food->getisDailyItem() === false || $food->getisMainMeal() === false) {
                continue;
            }
            $names[] = $food->getName();
            $prices[] = number_format($food->getPrice(),2);
        }
        $attachments[] = [
            'title' => 'Preporuka za ' . $this->getUser()->getName(),
            'title_link' => $fullMenuLink,
            'fields' => [
                [
                    'title' => 'Jelo',
                    'value' => implode(PHP_EOL, $names),
                    'short' => true
                ],
                [
                    'title' => 'Cijena',
                    'value' => implode(PHP_EOL, $prices),
                    'short' => true
                ]
            ]
        ];

        return $attachments;
    }

    private function getDailyMenuAttachments()
    {
        $fullMenuLink = $this->container->get('router')->generate('food.menu.full', [], UrlGeneratorInterface::ABSOLUTE_URL);
        $restaraunts = $this->container->get('doctrine.orm.default_entity_manager')
            ->getRepository('App:Restaraunt')
            ->getRestaurantsWithDailyItems();

        $attachments = [];
        /** @var Restaraunt $restaraunt */
        foreach ($restaraunts as $restaraunt) {
            $names = [];
            $prices = [];
            foreach($restaraunt->getFoods() as $food) {
                if($food->getisDailyItem() === false || $food->getisMainMeal() === false) {
                    continue;
                }
                $names[] = $food->getName();
                $prices[] = number_format($food->getPrice(),2);
            }
            $attachments[] = [
                'title' => $restaraunt->getName(),
                'title_link' => $fullMenuLink,
                'fields' => [
                    [
                        'title' => 'Jelo',
                        'value' => implode(PHP_EOL, $names),
                        'short' => true
                    ],
                    [
                        'title' => 'Cijena',
                        'value' => implode(PHP_EOL, $prices),
                        'short' => true
                    ]
                ]
            ];
        }

        return $attachments;
    }
}