<?php


namespace App\Event;


use App\Conversation\FoodDeliveredConversation;
use App\Entity\Order;
use BotMan\BotMan\BotMan;
use BotMan\Drivers\Slack\SlackDriver;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Events;
use Psr\Container\ContainerInterface;

class DeliveredEventSubscriber implements EventSubscriber
{
    protected $botman;
    protected $foodDeliveredConversation;

    /**
     * DeliveredEventSubscriber constructor.
     * @param BotMan $botman
     */
    public function __construct(BotMan $botman, FoodDeliveredConversation $foodDeliveredConversation)
    {
        $this->botman = $botman;
        $this->foodDeliveredConversation = $foodDeliveredConversation;
    }

    /**
     * Returns an array of events this subscriber wants to listen to.
     *
     * @return array
     */
    public function getSubscribedEvents()
    {
        return array(
            Events::postUpdate,
        );
    }

    public function postUpdate(LifecycleEventArgs $args) {
        $entity = $args->getObject();
        $entityManager = $args->getEntityManager();

        if ($entity instanceof Order) {
            $changed = $entityManager->getUnitOfWork()->getEntityChangeSet($entity);
            if(isset($changed['isDelivered']) && $entity->getIsDelivered()) {

                $users = $entityManager->getRepository('App:User')
                    ->getOrderParticipants($entity->getId());
                foreach($users as $user) {
                    $this->botman
                        ->startConversation(
                            $this->foodDeliveredConversation,
                            $user->getSlackId(),
                            SlackDriver::class
                        );
                }
            }
        }
    }
}