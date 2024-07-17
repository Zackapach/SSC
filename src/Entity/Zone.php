<?php

namespace App\Entity;

use App\Repository\ZoneRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ZoneRepository::class)]
class Zone
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 15)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\Column(length: 50)]
    private ?string $location = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?user $user = null;

    /**
     * @var Collection<int, Cour>
     */
    #[ORM\OneToMany(targetEntity: Cour::class, mappedBy: 'zone', orphanRemoval: true)]
    private Collection $cour;

    /**
     * @var Collection<int, Planing>
     */
    #[ORM\OneToMany(targetEntity: Planing::class, mappedBy: 'zone', orphanRemoval: true)]
    private Collection $planing;

    public function __construct()
    {
        $this->cour = new ArrayCollection();
        $this->planing = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
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

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(string $location): static
    {
        $this->location = $location;

        return $this;
    }

    public function getUser(): ?user
    {
        return $this->user;
    }

    public function setUser(user $user): static
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection<int, Cour>
     */
    public function getCour(): Collection
    {
        return $this->cour;
    }

    public function addCour(Cour $cour): static
    {
        if (!$this->cour->contains($cour)) {
            $this->cour->add($cour);
            $cour->setZone($this);
        }

        return $this;
    }

    public function removeCour(Cour $cour): static
    {
        if ($this->cour->removeElement($cour)) {
            // set the owning side to null (unless already changed)
            if ($cour->getZone() === $this) {
                $cour->setZone(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Planing>
     */
    public function getPlaning(): Collection
    {
        return $this->planing;
    }

    public function addPlaning(Planing $planing): static
    {
        if (!$this->planing->contains($planing)) {
            $this->planing->add($planing);
            $planing->setZone($this);
        }

        return $this;
    }

    public function removePlaning(Planing $planing): static
    {
        if ($this->planing->removeElement($planing)) {
            // set the owning side to null (unless already changed)
            if ($planing->getZone() === $this) {
                $planing->setZone(null);
            }
        }

        return $this;
    }
}
