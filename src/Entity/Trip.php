<?php

namespace App\Entity;

use App\Repository\TripRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TripRepository::class)]
class Trip
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 50)]
    private $name;

    #[ORM\Column(type: 'string', length: 255)]
    private $informations;

    #[ORM\Column(type: 'datetime')]
    private $starting_date;

    #[ORM\Column(type: 'datetime')]
    private $ending_date;

    #[ORM\Column(type: 'integer')]
    private $duration;

    #[ORM\Column(type: 'integer')]
    private $max_attendees;

    #[ORM\ManyToMany(targetEntity: User::class, mappedBy: 'trips')]
    private $users;

    #[ORM\ManyToOne(targetEntity: Place::class, inversedBy: 'trips')]
    #[ORM\JoinColumn(nullable: false)]
    private $place;

    #[ORM\ManyToOne(targetEntity: State::class, inversedBy: 'trips')]
    #[ORM\JoinColumn(nullable: false)]
    private $state;

    #[ORM\OneToMany(mappedBy: 'organized_trips', targetEntity: User::class)]
    private $organizer;

    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->organizer = new ArrayCollection();
    }

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

    public function getInformations(): ?string
    {
        return $this->informations;
    }

    public function setInformations(string $informations): self
    {
        $this->informations = $informations;

        return $this;
    }

    public function getStartingDate(): ?\DateTimeInterface
    {
        return $this->starting_date;
    }

    public function setStartingDate(\DateTimeInterface $starting_date): self
    {
        $this->starting_date = $starting_date;

        return $this;
    }

    public function getEndingDate(): ?\DateTimeInterface
    {
        return $this->ending_date;
    }

    public function setEndingDate(\DateTimeInterface $ending_date): self
    {
        $this->ending_date = $ending_date;

        return $this;
    }

    public function getDuration(): ?int
    {
        return $this->duration;
    }

    public function setDuration(int $duration): self
    {
        $this->duration = $duration;

        return $this;
    }

    public function getMaxAttendees(): ?int
    {
        return $this->max_attendees;
    }

    public function setMaxAttendees(int $max_attendees): self
    {
        $this->max_attendees = $max_attendees;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->addTrip($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            $user->removeTrip($this);
        }

        return $this;
    }

    public function getPlace(): ?Place
    {
        return $this->place;
    }

    public function setPlace(?Place $place): self
    {
        $this->place = $place;

        return $this;
    }

    public function getState(): ?State
    {
        return $this->state;
    }

    public function setState(?State $state): self
    {
        $this->state = $state;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getOrganizer(): Collection
    {
        return $this->organizer;
    }

    public function addOrganizer(User $organizer): self
    {
        if (!$this->organizer->contains($organizer)) {
            $this->organizer[] = $organizer;
            $organizer->setOrganizedTrips($this);
        }

        return $this;
    }

    public function removeOrganizer(User $organizer): self
    {
        if ($this->organizer->removeElement($organizer)) {
            // set the owning side to null (unless already changed)
            if ($organizer->getOrganizedTrips() === $this) {
                $organizer->setOrganizedTrips(null);
            }
        }

        return $this;
    }
}
