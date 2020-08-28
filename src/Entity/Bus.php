<?php

namespace App\Entity;

use App\Repository\BusRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BusRepository::class)
 */
class Bus
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $plank;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $busStop;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $color;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPlank(): ?int
    {
        return $this->plank;
    }

    public function setPlank(int $plank): self
    {
        $this->plank = $plank;

        return $this;
    }

    public function getBusStop(): ?string
    {
        return $this->busStop;
    }

    public function setBusStop(string $busStop): self
    {
        $this->busStop = $busStop;

        return $this;
    }

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(string $color): self
    {
        $this->color = $color;

        return $this;
    }
}
