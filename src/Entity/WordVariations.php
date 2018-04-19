<?php


namespace App\Entity;


use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Index;

/**
 * @ORM\Entity()
 * @ORM\Table(name="word_variations", indexes={@Index(name="word_variations_variation_index", columns={"variation"})})
 * Class WordVariations
 * @package App\Entity
 */
class WordVariations
{
    /**
     * @ORM\Id()
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     */
    protected $variation;

    /**
     * @ORM\Column(type="string")
     */
    protected $word;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return WordVariations
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getVariation()
    {
        return $this->variation;
    }

    /**
     * @param mixed $variation
     * @return WordVariations
     */
    public function setVariation($variation)
    {
        $this->variation = $variation;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getWord()
    {
        return $this->word;
    }

    /**
     * @param mixed $word
     * @return WordVariations
     */
    public function setWord($word)
    {
        $this->word = $word;
        return $this;
    }


}