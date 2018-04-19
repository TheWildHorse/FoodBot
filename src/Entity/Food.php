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
     * @ORM\Column(type="decimal", precision=8)
     */
    private $price;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $shortName;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isDailyItem;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isMainMeal = true;

    /**
     * @ORM\Column(type="text")
     */
    private $keywordText = '';

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

    /**
     * @return mixed
     */
    public function getisDailyItem()
    {
        return $this->isDailyItem;
    }

    /**
     * @param mixed $isDailyItem
     * @return Food
     */
    public function setIsDailyItem($isDailyItem)
    {
        $this->isDailyItem = $isDailyItem;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getisMainMeal()
    {
        return $this->isMainMeal;
    }

    /**
     * @param mixed $isMainMeal
     * @return Food
     */
    public function setIsMainMeal($isMainMeal)
    {
        $this->isMainMeal = $isMainMeal;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getKeywordText()
    {
        return $this->keywordText;
    }

    /**
     * @param mixed $keywordText
     * @return Food
     */
    public function setKeywordText($keywordText)
    {
        $this->keywordText = $keywordText;
        return $this;
    }

}
