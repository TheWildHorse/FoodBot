<?php


namespace App\Conversation;


use App\Entity\Restaraunt;
use App\Helper\MarkdownTableHelper;
use App\Services\Communication\ContainerAwareConversationTrait;
use App\Services\NLP\KeywordProcessingService;
use BotMan\BotMan\Messages\Conversations\Conversation;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Outgoing\OutgoingMessage;
use BotMan\BotMan\Messages\Outgoing\Question;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class FavouritesConversation extends Conversation
{
    use ContainerAwareConversationTrait;

    /**
     * @return mixed
     */
    public function run()
    {
        $this->say('Bok! Nismo se još upoznali, pa dozvoli da se predstavim.');
        $this->say('Ja sam FoodBot - svako jutro se brinem da ne ostaneš gladan. Kako bi ti mogao predložiti jela koja ti se posebno sviđaju moraš mi reći što voliš.');
        $question = Question::create('Koja su ti omiljena jela?')
            ->callbackId('favourites_response');

        $this->ask($question, function (Answer $answer) {
            if($answer->getCallbackId() === 'favourites_response') {
                $em = $this->container->get('doctrine.orm.default_entity_manager');
                $user = $em->getRepository('App:User')->findOneBy(['slackId' => $this->getBot()->getUser()->getId()]);
                $kps = $this->container->get(KeywordProcessingService::class);
                $user->setFavourites($kps->getKeywordsFromText($answer->getText()));
                $em->persist($user);
                $em->flush();

                $this->say('Okej, sad znam što voliš!');
                $this->getBot()->startConversation($this->container->get(InitiateOrderConversation::class));
            }
        });
    }
}