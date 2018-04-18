<?php


namespace App\Services\Payment;


use App\Entity\OrderItem;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class PaymentProcessingService
{

    /**
     * @var EntityManagerInterface
     */
    protected $em;

    /**
     * PaymentProcessingService constructor.
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function processPaymentForTodaysItems(User $user)
    {
        $items = $this->em->getRepository('App:OrderItem')
            ->getTodaysOrderItemsForUser($user);
        if($items === null) {
            return PaymentResultEnum::PAYMENT_NOT_NEEDED;
        }
        $total = 0;
        /** @var OrderItem $item */
        foreach ($items as $item) {
            $total += $item->getFood()->getPrice();
        }

        if($total <= $user->getMoneyBalance()) {
            $user->setMoneyBalance($user->getMoneyBalance() - $total);
            foreach ($items as $item) {
                $item->setIsPaid(true);
                $this->em->persist($item);
            }
            $this->em->flush();
            return PaymentResultEnum::PAYMENT_SUCCESS_FROM_BALANCE;
        }
        return PaymentResultEnum::PAYMENT_REQUIRED_MANUALLY;
    }
}