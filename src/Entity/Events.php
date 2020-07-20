<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EventsRepository")
 */
class Events
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @Groups("api_data")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Groups("api_data")
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @Groups("api_data")
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @Groups("api_data")
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $date_created;

    /**
     * @Groups("api_data")
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $deleted;

    /**
     * @Groups("api_data")
     * @ORM\ManyToOne(targetEntity="App\Entity\Users", inversedBy="events")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @Groups("api_data")
     * @ORM\ManyToOne(targetEntity="App\Entity\EventStatus")
     * @ORM\JoinColumn(nullable=false)
     */
    private $status;

    /**
     * @Groups("api_data")
     * @ORM\ManyToOne(targetEntity="App\Entity\EventPriorities")
     * @ORM\JoinColumn(nullable=false)
     */
    private $priority;

    /**
     * @Groups("api_data")
     * @ORM\Column(type="string", length=500, nullable=true)
     */
    private $photo1_filename;

    /**
     * @Groups("api_data")
     * @ORM\ManyToOne(targetEntity="App\Entity\Users")
     */
    private $last_comment_user;

    /**
     * @Groups("api_data")
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $last_comment_date;

    /**
     * @Groups("api_data")
     * @ORM\Column(type="text", nullable=true)
     */
    private $last_comment_text;

    /**
     * @Groups("api_data")
     * @ORM\Column(type="string", length=500, nullable=true)
     */
    private $phone;
    
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

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

    public function getDeleted(): ?bool
    {
        return $this->deleted;
    }

    public function setDeleted(?bool $deleted): self
    {
        $this->deleted = $deleted;

        return $this;
    }

    public function getUser(): ?Users
    {
        return $this->user;
    }

    public function setUser(?Users $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getStatus(): ?EventStatus
    {
        return $this->status;
    }

    public function setStatus(?EventStatus $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getPriority(): ?EventPriorities
    {
        return $this->priority;
    }

    public function setPriority(?EventPriorities $priority): self
    {
        $this->priority = $priority;

        return $this;
    }

    public function getPhoto1Filename(): ?string
    {
        return $this->photo1_filename;
    }

    public function setPhoto1Filename(?string $photo1_filename): self
    {
        $this->photo1_filename = $photo1_filename;

        return $this;
    }

    public function getLastCommentUser(): ?Users
    {
        return $this->last_comment_user;
    }

    public function setLastCommentUser(?Users $last_comment_user): self
    {
        $this->last_comment_user = $last_comment_user;

        return $this;
    }

    public function getLastCommentDate(): ?\DateTimeInterface
    {
        return $this->last_comment_date;
    }

    public function setLastCommentDate(?\DateTimeInterface $last_comment_date): self
    {
        $this->last_comment_date = $last_comment_date;

        return $this;
    }

    public function getLastCommentText(): ?string
    {
        return $this->last_comment_text;
    }

    public function setLastCommentText(?string $last_comment_text): self
    {
        $this->last_comment_text = $last_comment_text;

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
