<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\LogsRepository")
 */
class Logs
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=500)
     */
    private $action_name;
    
    /**
     * @ORM\Column(type="integer")
     */
    private $action_value;
 
    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $action_info;
    
    /**
     * @ORM\Column(type="datetime")
     */
    private $date_created;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Users")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\Column(type="string", length=500, nullable=true)
     */
    private $action_title;
    
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getActionName(): ?string
    {
        return $this->action_name;
    }

    public function setActionName(string $action_name): self
    {
        $this->action_name = $action_name;

        return $this;
    }
    
    public function getActionValue(): ?int
    {
        return $this->action_value;
    }

    public function setActionValue(int $action_value): self
    {
        $this->action_value = $action_value;

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

    public function getDateCreated(): ?\DateTimeInterface
    {
        return $this->date_created;
    }

    public function setDateCreated(\DateTimeInterface $date_created): self
    {
        $this->date_created = $date_created;

        return $this;
    }

    public function getActionInfo(): ?string
    {
        return $this->action_info;
    }

    public function setActionInfo(?string $action_info): self
    {
        $this->action_info = $action_info;

        return $this;
    }

    public function getActionTitle(): ?string
    {
        return $this->action_title;
    }

    public function setActionTitle(?string $action_title): self
    {
        $this->action_title = $action_title;

        return $this;
    }
}
