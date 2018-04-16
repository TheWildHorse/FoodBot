<?php


namespace App\Conversation;


use App\Entity\OrderItem;
use App\Entity\Restaraunt;
use App\Helper\MarkdownTableHelper;
use App\Services\Communication\ContainerAwareConversationTrait;
use BotMan\BotMan\Messages\Conversations\Conversation;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Outgoing\Question;
use BotMan\Drivers\Slack\Extensions\Menu;

class OrderConversation extends Conversation
{
    use ContainerAwareConversationTrait;

    /**
     * @return mixed
     */
    public function run()
    {
        $currentOrder = $this->getCurrentOrderAttachment();
        if($currentOrder === null) {
            $question = Question::create('Šta\'š jest?')->callbackId('food_selection')->addAction(Menu::create('Upiši ili odaberi...')->name('food_list')->options($this->getFoodChoices()));

            $this->ask($question, function (Answer $answer) {
                $selectedOptions = $answer->getValue();
                $this->addOrderItem($selectedOptions[0]['value']);
            });
        }
        else {
            $this->say('Tvoja narudžba:', [
                'attachments' => json_encode($currentOrder)
            ]);
            $question = Question::create('Želiš li još nešto?')
                ->callbackId('food_selection')
                ->addAction(
                    Menu::create('Upiši ili odaberi...')
                    ->name('food_list')
                    ->options($this->getFoodChoices())
                )
                ->addButton(
                    Button::create(':white_check_mark: To je to!')
                        ->name('done_button')
                        ->value('yes')
                );

            $this->ask($question, function (Answer $answer) {
                if ($answer->isInteractiveMessageReply()) {
                    // ToDo: Start Payment Conversation
                    return;
                }
                $selectedOptions = $answer->getValue();
                $this->addOrderItem($selectedOptions[0]['value']);
            });
        }
    }

    /**
     * @return array
     */
    private function getFoodChoices(): array
    {
        $foods = $this->container->get('doctrine.orm.default_entity_manager')
            ->getRepository('App:Food')
            ->findBy([], ['name'=>'ASC']);

        $choiceArray = [];
        foreach ($foods as $food) {
            $choiceArray[] = [
                'text' => $food->getName(),
                'value' => $food->getId(),
            ];
        }

        return $choiceArray;
    }

    private function getUser() {
        return $this->container->get('doctrine.orm.default_entity_manager')
            ->getRepository('App:User')
            ->findOneBy(['slackId' => $this->getBot()->getUser()->getId()]);
    }

    private function addOrderItem($itemId) {
        $em = $this->container->get('doctrine.orm.default_entity_manager');
        $food = $em->getRepository('App:Food')
            ->find($itemId);
        $order = $this->container->get('doctrine.orm.default_entity_manager')
            ->getRepository('App:Order')
            ->getOrCreateOrder($food->getRestaurant());
        $orderItem = new OrderItem();
        $orderItem->setOrder($order);
        $orderItem->setFood($food);
        $orderItem->setUser($this->getUser());
        $orderItem->setDate(new \DateTime());
        $order->addOrderItem($orderItem);
        $em->persist($order);
        $em->persist($orderItem);
        $em->flush();

        $this->getBot()->startConversation(
            $this->container->get(OrderConversation::class)
        );
    }

    private function getCurrentOrderAttachment()
    {
        $em = $this->container->get('doctrine.orm.default_entity_manager');
        $currentOrder = $em->getRepository('App:OrderItem')->getTodaysOrderItemsForUser($this->getUser());
        if($currentOrder === null) {
            return null;
        }

        $names = [];
        $prices = [];
        $total = 0;
        /** @var OrderItem $orderItem */
        foreach($currentOrder as $orderItem) {
            $names[] = $orderItem->getFood()->getName();
            $prices[] = number_format($orderItem->getFood()->getPrice(),2);
            $total += $orderItem->getFood()->getPrice();
        }
        $attachments = [
            [
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
                    ],
                    [
                        'title' => 'Ukupno',
                        'value' => number_format($total, 2),
                        'short' => false
                    ]
                ]
            ]
        ];

        return $attachments;
    }

}