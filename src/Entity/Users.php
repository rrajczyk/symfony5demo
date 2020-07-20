<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UsersRepository")
 */
class Users implements UserInterface
{
    /**
     * @Groups("api_data")
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Groups("api_data")
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $username;

    /**
     * @Groups("api_data")
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @Groups("user")
     * @ORM\OneToMany(targetEntity="App\Entity\Events", mappedBy="user")
     */
    private $events;

    /**
     * @Groups("api_data")
     * @ORM\ManyToOne(targetEntity="App\Entity\UserTypes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user_type;

    /**
     * @Groups("api_data")
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @Groups("api_data")
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $address;

    /**
     * @Groups("api_data")
     * @ORM\Column(type="string", length=500, nullable=true)
     */
    private $avatar_filename;

    /**
     * @Groups("api_data")
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $date_created;

    /**
     * @Groups("api_data")
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $date_login;

    /**
     * @Groups("api_data")
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $deleted;

    /**
     * @Groups("api_data")
     * @ORM\Column(type="string", length=500, nullable=true)
     */
    private $emails;
    
    /**
     * @Groups("api_data")
     * @ORM\Column(type="string", length=500, nullable=true)
     */
    private $phone;

    public function __construct()
    {
        $this->events = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
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
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
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
     * @return Collection|Events[]
     */
    public function getEvents(): Collection
    {
        return $this->events;
    }

    public function addEvent(Events $event): self
    {
        if (!$this->events->contains($event)) {
            $this->events[] = $event;
            $event->setUser($this);
        }

        return $this;
    }

    public function removeEvent(Events $event): self
    {
        if ($this->events->contains($event)) {
            $this->events->removeElement($event);
            // set the owning side to null (unless already changed)
            if ($event->getUser() === $this) {
                $event->setUser(null);
            }
        }

        return $this;
    }

    public function getUserType(): ?UserTypes
    {
        return $this->user_type;
    }

    public function setUserType(?UserTypes $user_type): self
    {
        $this->user_type = $user_type;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getAvatarFilename(): ?string
    {
        return $this->avatar_filename;
    }

    public function setAvatarFilename(?string $avatar_filename): self
    {
        $this->avatar_filename = $avatar_filename;

        return $this;
    }

    public function getDateCreated(): ?\DateTimeInterface
    {
        return $this->date_created;
    }

    public function setDateCreated(?\DateTimeInterface $date_created): self
    {
        $this->date_created = $date_created;

        return $this;
    }

    public function getDateLogin(): ?\DateTimeInterface
    {
        return $this->date_login;
    }

    public function setDateLogin(?\DateTimeInterface $date_login): self
    {
        $this->date_login = $date_login;

        return $this;
    }    
    
    public function __toString()
    {
        return $this->name;
    }

    public function getDeleted(): ?bool
    {
        return $this->deleted;
    }

    public function setDeleted(?bool $deleted): self
    {
        $this->deleted = $deleted;

        return $this;
    }

    public function getEmails(): ?string
    {
        return $this->emails;
    }

    public function setEmails(?string $emails): self
    {
        $this->emails = $emails;

        return $this;
    }
    
    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }
}
