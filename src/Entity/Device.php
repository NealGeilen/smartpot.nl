<?php

namespace App\Entity;

use App\Repository\DeviceRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=DeviceRepository::class)
 */
class Device
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="devices")
     * @ORM\JoinColumn(nullable=false)
     */
    private $User;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $Token;

    /**
     * @ORM\Column(type="datetime")
     */
    private $LastAction;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->User;
    }

    public function setUser(?UserInterface $User): self
    {
        $this->User = $User;

        return $this;
    }

    public function getToken(): ?string
    {
        return $this->Token;
    }

    public function setToken(string $Token): self
    {
        $this->Token = $Token;

        return $this;
    }

    public function getLastAction(): ?\DateTimeInterface
    {
        return $this->LastAction;
    }

    public function setLastAction(\DateTimeInterface $LastAction): self
    {
        $this->LastAction = $LastAction;

        return $this;
    }
}
