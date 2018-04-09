<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FoodRepository")
 */
class Food
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $name;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $healthScore;

    /**
     * @ORM\Column(type="decimal", precision=2)
     */
    private $price;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $shortName;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Category", inversedBy="foods")
     */
    private $category;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Restaraunt", inversedBy="foods")
     * @ORM\JoinColumn(nullable=false)
     */
    private $restaurant;

    public function getId()
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getHealthScore(): ?int
    {
        return $this->healthScore;
    }

    public function setHealthScore(?int $healthScore): self
    {
        $this->healthScore = $healthScore;

        return $this;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function setPrice($price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getShortName(): ?string
    {
        return $this->shortName;
    }

    public function setShortName(?string $shortName): self
    {
        $this->shortName = $shortName;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getRestaurant(): ?Restaraunt
    {
        return $this->restaurant;
    }

    public function setRestaurant(?Restaraunt $restaurant): self
    {
        $this->restaurant = $restaurant;

        return $this;
    }
}
