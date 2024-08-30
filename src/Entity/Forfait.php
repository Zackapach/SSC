<?php

namespace App\Entity;

use App\Repository\ForfaitRepository;
use App\Enum\ForfaitNameEnum;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ForfaitRepository::class)]
class Forfait
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $price = null;

    #[ORM\Column]
    private ?int $durationDays = null;

    #[ORM\Column(length: 10)]
    private ?string $typeForfait = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateDebut = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateFin = null;

    #[ORM\OneToOne(inversedBy: 'forfait', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?UserProfil $UserProfil = null;

    #[ORM\Column(type: Types::SIMPLE_ARRAY, enumType: ForfaitNameEnum::class)]
    private array $name = [];

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(string $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getDurationDays(): ?int
    {
        return $this->durationDays;
    }

    public function setDurationDays(int $durationDays): static
    {
        $this->durationDays = $durationDays;

        return $this;
    }

    public function getTypeForfait(): ?string
    {
        return $this->typeForfait;
    }

    public function setTypeForfait(string $typeForfait): static
    {
        $this->typeForfait = $typeForfait;

        return $this;
    }

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->dateDebut;
    }

    public function setDateDebut(\DateTimeInterface $dateDebut): static
    {
        $this->dateDebut = $dateDebut;

        return $this;
    }

    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->dateFin;
    }

    public function setDateFin(\DateTimeInterface $dateFin): static
    {
        $this->dateFin = $dateFin;

        return $this;
    }

    public function getUserProfil(): ?UserProfil
    {
        return $this->UserProfil;
    }

    public function setUserProfil(UserProfil $UserProfil): static
    {
        $this->UserProfil = $UserProfil;

        return $this;
    }

    /**
     * @return ForfaitNameEnum[]
     */
    public function getName(): array
    {
        return $this->name;
    }

    public function setName(array $name): static
    {
        $this->name = $name;

        return $this;
    }
}
