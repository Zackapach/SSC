<?php

namespace App\Entity;

use App\Repository\NotificationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: NotificationRepository::class)]
class Notification
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $message = null;

    #[ORM\Column]
    private ?bool $readStatus = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\ManyToOne(inversedBy: 'notifications')]
    #[ORM\JoinColumn(nullable: false)]
    private ?user $user = null;

    /**
     * @var Collection<int, Cour>
     */
    #[ORM\OneToMany(targetEntity: Cour::class, mappedBy: 'notifcation', orphanRemoval: true)]
    private Collection $cour;

    public function __construct()
    {
        $this->cour = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(string $message): static
    {
        $this->message = $message;

        return $this;
    }

    public function isReadStatus(): ?bool
    {
        return $this->readStatus;
    }

    public function setReadStatus(bool $readStatus): static
    {
        $this->readStatus = $readStatus;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUser(): ?user
    {
        return $this->user;
    }

    public function setUser(?user $user): static
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
            $cour->setNotifcation($this);
        }

        return $this;
    }

    public function removeCour(Cour $cour): static
    {
        if ($this->cour->removeElement($cour)) {
            // set the owning side to null (unless already changed)
            if ($cour->getNotifcation() === $this) {
                $cour->setNotifcation(null);
            }
        }

        return $this;
    }
}
