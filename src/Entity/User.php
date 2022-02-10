<?php
namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;
/**
* @UniqueEntity(fields={"email"}, message="There is already an account with this email")
*/


/**
* @Vich\Uploadable
*/
#[ORM\Entity(repositoryClass: UserRepository::class)]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
#[ORM\Id]
#[ORM\GeneratedValue]
#[ORM\Column(type: 'integer')]
private $id;

#[ORM\Column(type: 'string', length: 180, unique: true)]
#[Assert\Email(message: "The email '{{ value }}' is not a valid email.")]
private $email;

#[ORM\Column(type: 'json')]
private $roles = [];

#[ORM\Column(type: 'string')]
private $password;

#[ORM\ManyToMany(targetEntity: Trip::class, inversedBy: 'users')]
private $trips;

#[ORM\ManyToOne(targetEntity: Site::class, inversedBy: 'users')]
#[ORM\JoinColumn(nullable: false)]
private $site;

#[ORM\OneToMany(targetEntity: Trip::class, mappedBy: 'organizer')]
private $organized_trips;

#[ORM\Column(type: 'string', length: 50)]
private $username;

#[ORM\Column(type: 'string', length: 50)]
private $name;

#[ORM\Column(type: 'string', length: 50)]
private $surname;


#[Assert\Regex(pattern: "/^(0)[1-9]([-. ]?[0-9]{2} ){3}([-. ]?[0-9]{2})$/" ,message: "Veuillez rentrer un numéro de téléphone qui respecte cet format SVP : 0X XX XX XX XX") ]
#[ORM\Column(type: 'string', length: 15)]
private $phone;

#[ORM\Column(type: 'boolean', nullable: true)]
private $is_admin;

#[ORM\Column(type: 'boolean', nullable: true)]
private $is_active;

#[ORM\Column(type: 'string', length: 255, nullable: true)]
private $PictureLink;

/**
* @Vich\UploadableField(mapping="user_picture", fileNameProperty="PictureLink")
* @param File|UploadedFile|null $fichierImage
*/
private $pictureFile;
public function __construct()
{
$this->trips = new ArrayCollection();
}

public function getId(): ?int
{
return $this->id;
}

public function getEmail(): ?string
{
return $this->email;
}

public function setEmail(string $email): self
{
$this->email = $email;

return $this;
}

/**
* A visual identifier that represents this user.
*
* @see UserInterface
*/
public function getUserIdentifier(): string
{
return (string) $this->email;
}

/**
* @see UserInterface
*/
public function getRoles(): array
{
$roles = $this->roles;
// guarantee every user at least has ROLE_USER
$roles[] = 'ROLE_USER';

return array_unique($roles);
}

public function setRoles(array $roles): self
{
$this->roles = $roles;

return $this;
}

/**
* @see PasswordAuthenticatedUserInterface
*/
public function getPassword(): string
{
return $this->password;
}

public function setPassword(string $password): self
{
$this->password = $password;

return $this;
}

/**
* @see UserInterface
*/
public function eraseCredentials()
{
// If you store any temporary, sensitive data on the user, clear it here
// $this->plainPassword = null;
}

/**
* @return Collection|Trip[]
*/
public function getTrips(): Collection
{
return $this->trips;
}

public function addTrip(Trip $trip): self
{
if (!$this->trips->contains($trip)) {
$this->trips[] = $trip;
}

return $this;
}

public function removeTrip(Trip $trip): self
{
$this->trips->removeElement($trip);

return $this;
}

public function getSite(): ?Site
{
return $this->site;
}

public function setSite(?Site $site): self
{
$this->site = $site;

return $this;
}

public function getOrganizedTrips(): ?Trip
{
return $this->organized_trips;
}

public function setOrganizedTrips(?Trip $organized_trips): self
{
$this->organized_trips = $organized_trips;

return $this;
}

public function getUsername(): ?string
{
return $this->username;
}

public function setUsername(string $username): self
{
$this->username = $username;

return $this;
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

public function getSurname(): ?string
{
return $this->surname;
}

public function setSurname(string $surname): self
{
$this->surname = $surname;

return $this;
}

public function getPhone(): ?string
{
return $this->phone;
}

public function setPhone(string $phone): self
{
$this->phone = $phone;

return $this;
}

public function getIsAdmin(): ?bool
{
return $this->is_admin;
}

public function setIsAdmin(bool $is_admin): self
{
$this->is_admin = $is_admin;

return $this;
}

public function getIsActive(): ?bool
{
return $this->is_active;
}

public function setIsActive(bool $is_active): self
{
$this->is_active = $is_active;

return $this;
}

public function getPictureLink(): ?string
{
return $this->PictureLink;
}

public function setPictureLink(?string $PictureLink): self
{
$this->PictureLink = $PictureLink;

return $this;
}

/**
* @return mixed
*/
public function getPictureFile():mixed
{
return $this->pictureFile;
}

public function setPictureFile(?File $fichier = null): self
{
$this->pictureFile = $fichier;
if ($fichier) {
$this->author = '';
}
return $this;
}


}
