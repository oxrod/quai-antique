<?php

namespace App\Entity;

use App\Repository\ScheduleRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ScheduleRepository::class)]
class Schedule
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $day = null;

    #[ORM\Column(type: Types::TIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $lunchStartTime = null;

    #[ORM\Column(type: Types::TIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $lunchStopTime = null;

    #[ORM\Column(type: Types::TIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dinerStartTime = null;

    #[ORM\Column(type: Types::TIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dinerStopTime = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDay(): ?string
    {
        return $this->day;
    }

    public function setDay(string $day): self
    {
        $this->day = $day;

        return $this;
    }

    public function getLunchStartTime(): ?\DateTimeInterface
    {
        return $this->lunchStartTime;
    }

    public function setLunchStartTime(?\DateTimeInterface $lunchStartTime): self
    {
        $this->lunchStartTime = $lunchStartTime;

        return $this;
    }

    public function getLunchStopTime(): ?\DateTimeInterface
    {
        return $this->lunchStopTime;
    }

    public function setLunchStopTime(?\DateTimeInterface $lunchStopTime): self
    {
        $this->lunchStopTime = $lunchStopTime;

        return $this;
    }

    public function getDinerStartTime(): ?\DateTimeInterface
    {
        return $this->dinerStartTime;
    }

    public function setDinerStartTime(?\DateTimeInterface $dinerStartTime): self
    {
        $this->dinerStartTime = $dinerStartTime;

        return $this;
    }

    public function getDinerStopTime(): ?\DateTimeInterface
    {
        return $this->dinerStopTime;
    }

    public function setDinerStopTime(?\DateTimeInterface $dinerStopTime): self
    {
        $this->dinerStopTime = $dinerStopTime;

        return $this;
    }
}
