<?php

namespace App\Entity;

use App\Repository\RestaurantRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RestaurantRepository::class)]
class Restaurant
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?int $maxGuestCapacity = null;

    #[ORM\Column]
    private ?int $remainingGuestCapacity = null;

    public function getId(): ?int
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

    public function getMaxGuestCapacity(): ?int
    {
        return $this->maxGuestCapacity;
    }

    public function setMaxGuestCapacity(int $maxGuestCapacity): self
    {
        $this->maxGuestCapacity = $maxGuestCapacity;

        return $this;
    }

    public function getRemainingGuestCapacity(): ?int
    {
        return $this->remainingGuestCapacity;
    }

    public function setRemainingGuestCapacity(int $remainingGuestCapacity): self
    {
        $this->remainingGuestCapacity = $remainingGuestCapacity;

        return $this;
    }
}
