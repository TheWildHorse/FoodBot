<?php

namespace App\Entity;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\OrderRepository")
 * @ORM\Table(name="orders")
 */
class Order
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Restaraunt", inversedBy="orders")
     * @ORM\JoinColumn(nullable=false)
     */
    private $restaraunt;

    /**
     * @ORM\Column(type="boolean")
     */
    private $autoorder;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isOrdered;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isDelivered;

    /**
     * @ORM\Column(type="datetime")
     */
    private $endTime;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\OrderItem", mappedBy="order", orphanRemoval=true)
     */
    private $orderItems;

    /**
     * @ORM\PostUpdate()
     * @param LifecycleEventArgs $event
     */
    public function postUpdate(LifecycleEventArgs $event)
    {
        if ($event->hasChangedField('isDelivered')) {
            die("test");
        }
    }

    public function getId()
    {
        return $this->id;
    }

    public function getRestaraunt(): ?Restaraunt
    {
        return $this->restaraunt;
    }

    public function setRestaraunt(?Restaraunt $restaraunt): self
    {
        $this->restaraunt = $restaraunt;

        return $this;
    }

    public function getAutoorder(): ?bool
    {
        return $this->autoorder;
    }

    public function setAutoorder(bool $autoorder): self
    {
        $this->autoorder = $autoorder;

        return $this;
    }

    public function getIsOrdered(): ?bool
    {
        return $this->isOrdered;
    }

    public function setIsOrdered(bool $isOrdered): self
    {
        $this->isOrdered = $isOrdered;

        return $this;
    }

    public function getIsDelivered(): ?bool
    {
        return $this->isDelivered;
    }

    public function setIsDelivered(bool $isDelivered): self
    {
        $this->isDelivered = $isDelivered;

        return $this;
    }

    public function getEndTime(): ?\DateTimeInterface
    {
        return $this->endTime;
    }

    public function setEndTime(\DateTimeInterface $endTime): self
    {
        $this->endTime = $endTime;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getOrderItems()
    {
        return $this->orderItems;
    }

    /**
     * @param mixed $orderItems
     * @return Order
     */
    public function setOrderItems($orderItems)
    {
        $this->orderItems = $orderItems;
        return $this;
    }

    public function addOrderItem($orderItem)
    {
        $this->orderItems[] = $orderItem;
        return $this;
    }
}
