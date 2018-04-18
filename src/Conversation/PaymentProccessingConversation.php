<?php


namespace App\Conversation;


use App\Entity\OrderItem;
use App\Entity\Restaraunt;
use App\Helper\MarkdownTableHelper;
use App\Services\Communication\ContainerAwareConversationTrait;
use App\Services\GiphyService;
use App\Services\Payment\PaymentProcessingService;
use App\Services\Payment\PaymentResultEnum;
use BotMan\BotMan\Messages\Attachments\Image;
use BotMan\BotMan\Messages\Conversations\Conversation;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Outgoing\OutgoingMessage;
use BotMan\BotMan\Messages\Outgoing\Question;
use BotMan\Drivers\Slack\Extensions\Menu;

class PaymentProccessingConversation extends Conversation
{
    use ContainerAwareConversationTrait;

    /**
     * @return mixed
     */
    public function run()
    {
        $user = $this->container->get('doctrine.orm.default_entity_manager')
            ->getRepository('App:User')
            ->findOneBy(['slackId' => $this->getBot()->getUser()->getId()]);

        $paymentResult = $this->container->get(PaymentProcessingService::class)
            ->processPaymentForTodaysItems($user);

        if($paymentResult === PaymentResultEnum::PAYMENT_NOT_NEEDED) {
            $this->say('Nisi ništa naručio, pa ni ne trebaš platiti!');
        }
        else if($paymentResult === PaymentResultEnum::PAYMENT_SUCCESS_FROM_BALANCE) {
            $this->say('Tvoja narudžba je plaćena sa tvog računa!');
        }
        else if($paymentResult === PaymentResultEnum::PAYMENT_REQUIRED_MANUALLY) {
            $this->say('Nemaš dovoljno novaca na računu! Nadoplati račun ili plati trenutnu naruđbu kod naručioca.');
        }
    }
}