<?php

namespace App\Entity;

use App\Repository\HistoryRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HistoryRepository::class)]
class History
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $firstIn = null;

    #[ORM\Column]
    private ?int $secondIn = null;

    #[ORM\Column]
    private ?int $firstOut = null;

    #[ORM\Column]
    private ?int $secondOut = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $data_utworzenia = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $data_aktualizacji = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstIn(): ?int
    {
        return $this->firstIn;
    }

    public function setFirstIn(int $firstIn): self
    {
        $this->firstIn = $firstIn;

        return $this;
    }

    public function getSecondIn(): ?int
    {
        return $this->secondIn;
    }

    public function setSecondIn(int $secondIn): self
    {
        $this->secondIn = $secondIn;

        return $this;
    }

    public function getFirstOut(): ?int
    {
        return $this->firstOut;
    }

    public function setFirstOut(int $firstOut): self
    {
        $this->firstOut = $firstOut;

        return $this;
    }

    public function getSecondOut(): ?int
    {
        return $this->secondOut;
    }

    public function setSecondOut(int $secondOut): self
    {
        $this->secondOut = $secondOut;

        return $this;
    }

    public function getDataUtworzenia(): ?\DateTimeInterface
    {
        return $this->data_utworzenia;
    }

    public function setDataUtworzenia(\DateTimeInterface $data_utworzenia): self
    {
        $this->data_utworzenia = $data_utworzenia;

        return $this;
    }

    public function getDataAktualizacji(): ?\DateTimeInterface
    {
        return $this->data_aktualizacji;
    }

    public function setDataAktualizacji(\DateTimeInterface $data_aktualizacji): self
    {
        $this->data_aktualizacji = $data_aktualizacji;

        return $this;
    }
}
