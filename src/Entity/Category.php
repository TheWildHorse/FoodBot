<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CategoryRepository")
 */
class Category
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $name;

    /**
     * @ORM\Column(type="text")
     */
    private $icon;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Food", mappedBy="category")
     */
    private $foods;

    public function __construct()
    {
        $this->foods = new ArrayCollection();
    }

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

    public function getIcon(): ?string
    {
        return $this->icon;
    }

    public function setIcon(string $icon): self
    {
        $this->icon = $icon;

        return $this;
    }

    /**
     * @return Collection|Food[]
     */
    public function getFoods(): Collection
    {
        return $this->foods;
    }

    public function addFood(Food $food): self
    {
        if (!$this->foods->contains($food)) {
            $this->foods[] = $food;
            $food->setCategory($this);
        }

        return $this;
    }

    public function removeFood(Food $food): self
    {
        if ($this->foods->contains($food)) {
            $this->foods->removeElement($food);
            // set the owning side to null (unless already changed)
            if ($food->getCategory() === $this) {
                $food->setCategory(null);
            }
        }

        return $this;
    }
}
