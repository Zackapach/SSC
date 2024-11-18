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

    #[ORM\OneToOne(inversedBy: 'zone', targetEntity: User::class, cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    private ?User $user = null;
    

    /**
     * @var Collection<int, course>
     */
    #[ORM\OneToMany(targetEntity: course::class, mappedBy: 'zone', orphanRemoval: true)]
    private Collection $course;

    
    public function __construct()
    {
        $this->course = new ArrayCollection();
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

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user, bool $inverseCall = true): self
    {
        // Évitez de réinitialiser la relation si elle est déjà correcte
        if ($this->user === $user) {
            return $this;
        }
    
        // Si un utilisateur existait déjà, déliez-le de cette zone
        if ($this->user !== null && $inverseCall) {
            $this->user->setZone(null, false);
        }
    
        // Mettez à jour la relation inverse si demandé
        if ($user !== null && $inverseCall) {
            $user->setZone($this, false);
        }
    
        $this->user = $user;
    
        return $this;
    }
    
    
    

    /**
     * @return Collection<int, course>
     */
    public function getCourse(): Collection
    {
        return $this->course;
    }

    public function addCourse(course $course): static
    {
        if (!$this->course->contains($course)) {
            $this->course->add($course);
            $course->setZone($this);
        }

        return $this;
    }

    public function removeCourse(course $course): static
    {
        if ($this->course->removeElement($course)) {
            // set the owning side to null (unless already changed)
            if ($course->getZone() === $this) {
                $course->setZone(null);
            }
        }

        return $this;
    }


}
