<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\OrderRepository")
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
}
