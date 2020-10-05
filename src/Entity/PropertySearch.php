<?php
namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use \Symfony\Component\Validator\Constraints as Assert;

class PropertySearch {
    /**
     * @var int|null
     */
    private $maxPrice;

    /**
     * @var int|null
     * @Assert\Range(min=10, max=400)
     */
    private $minSurface;

    /**
     * @var ArrayCollection
     */
    private $options;

    public function __construct()
    {
        $this->options = new ArrayCollection();
    }

    public function getMaxPrice(): ?int
    {
        return $this->maxPrice;
    }

    public function setMaxPrice(int $maxPrice): PropertySearch
    {
        $this->maxPrice = $maxPrice;
        return $this;
    }

    public function getMinsurface(): ?int
    {
        return $this->minSurface;
    }

    public function setMinsurface(int $minSurface): PropertySearch
    {
        $this->minSurface = $minSurface;
        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getOptions(): ArrayCollection
    {
        return $this->options;
    }

    /**
     * @param ArrayCollection
     */
    public function setOptions(ArrayCollection $options): void
    {
        $this->options = $options;
    }
}