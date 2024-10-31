<?php

namespace App\Entity;

use App\Repository\CourRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CourRepository::class)]
class Cour
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 20)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;


    #[ORM\Column]
    private ?int $duration = null;

    #[ORM\Column]
    private ?bool $disponible = null;

    #[ORM\ManyToOne(inversedBy: 'cour')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'cour')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Zone $zone = null;

    #[ORM\Column]
    private ?int $nombrePlaceDisponible = null;

    #[ORM\ManyToOne(inversedBy: 'cour')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Notification $notifcation = null;

    /**
     * @var Collection<int, Planning>
     */
    #[ORM\OneToMany(targetEntity: Planning::class, mappedBy: 'cour', orphanRemoval: true)]
    private Collection $planning;

    /**
     * @var Collection<int, Reservation>
     */
    #[ORM\OneToMany(targetEntity: Reservation::class, mappedBy: 'cour', orphanRemoval: true)]
    private Collection $reservation;

    /**
     * @var Collection<int, Avis>
     */
    #[ORM\OneToMany(targetEntity: Avis::class, mappedBy: 'cour', orphanRemoval: true)]
    private Collection $avis;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $calendrier = null;

    public function __construct()
    {
        $this->planning = new ArrayCollection();
        $this->reservation = new ArrayCollection();
        $this->avis = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

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

    public function getDuration(): ?int
    {
        return $this->duration;
    }

    public function setDuration(int $duration): static
    {
        $this->duration = $duration;

        return $this;
    }

    public function isDisponible(): ?bool
    {
        return $this->disponible;
    }

    public function setDisponible(bool $disponible): static
    {
        $this->disponible = $disponible;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getZone(): ?Zone
    {
        return $this->zone;
    }

    public function setZone(?Zone $zone): static
    {
        $this->zone = $zone;

        return $this;
    }

    public function getNombrePlaceDisponible(): ?int
    {
        return $this->nombrePlaceDisponible;
    }

    public function setNombrePlaceDisponible(int $nombrePlaceDisponible): static
    {
        $this->nombrePlaceDisponible = $nombrePlaceDisponible;

        return $this;
    }

    public function getNotifcation(): ?Notification
    {
        return $this->notifcation;
    }

    public function setNotifcation(?Notification $notifcation): static
    {
        $this->notifcation = $notifcation;

        return $this;
    }

    /**
     * @return Collection<int, Planning>
     */
    public function getPlanning(): Collection
    {
        return $this->planning;
    }

    public function addPlanning(Planning $planning): static
    {
        if (!$this->planning->contains($planning)) {
            $this->planning->add($planning);
            $planning->setCour($this);
        }

        return $this;
    }

    public function removePlanning(Planning $planning): static
    {
        if ($this->planning->removeElement($planning)) {
            // set the owning side to null (unless already changed)
            if ($planning->getCour() === $this) {
                $planning->setCour(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Reservation>
     */
    public function getReservation(): Collection
    {
        return $this->reservation;
    }

    public function addReservation(Reservation $reservation): static
    {
        if (!$this->reservation->contains($reservation)) {
            $this->reservation->add($reservation);
            $reservation->setCour($this);
        }

        return $this;
    }

    public function removeReservation(Reservation $reservation): static
    {
        if ($this->reservation->removeElement($reservation)) {
            // set the owning side to null (unless already changed)
            if ($reservation->getCour() === $this) {
                $reservation->setCour(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Avis>
     */
    public function getAvis(): Collection
    {
        return $this->avis;
    }

    public function addAvi(Avis $avi): static
    {
        if (!$this->avis->contains($avi)) {
            $this->avis->add($avi);
            $avi->setCour($this);
        }

        return $this;
    }

    public function removeAvi(Avis $avi): static
    {
        if ($this->avis->removeElement($avi)) {
            // set the owning side to null (unless already changed)
            if ($avi->getCour() === $this) {
                $avi->setCour(null);
            }
        }

        return $this;
    }

    public function getCalendrier(): ?\DateTimeInterface
    {
        return $this->calendrier;
    }

    public function setCalendrier(\DateTimeInterface $calendrier): static
    {
        $this->calendrier = $calendrier;

        return $this;
    }
}
