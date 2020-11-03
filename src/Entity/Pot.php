<?php

namespace App\Entity;

use App\Repository\PotRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PotRepository::class)
 */
class Pot
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $AddedDate;

    /**
     * @ORM\OneToMany(targetEntity=PotLog::class, mappedBy="PotId")
     */
    private $potLogs;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="pots")
     */
    private $Owner;

    public function __construct()
    {
        $this->potLogs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAddedDate(): ?\DateTimeInterface
    {
        return $this->AddedDate;
    }

    public function setAddedDate(\DateTimeInterface $AddedDate): self
    {
        $this->AddedDate = $AddedDate;

        return $this;
    }

    /**
     * @return Collection|PotLog[]
     */
    public function getPotLogs(): Collection
    {
        return $this->potLogs;
    }

    public function addPotLog(PotLog $potLog): self
    {
        if (!$this->potLogs->contains($potLog)) {
            $this->potLogs[] = $potLog;
            $potLog->setPotId($this);
        }

        return $this;
    }

    public function removePotLog(PotLog $potLog): self
    {
        if ($this->potLogs->removeElement($potLog)) {
            // set the owning side to null (unless already changed)
            if ($potLog->getPotId() === $this) {
                $potLog->setPotId(null);
            }
        }

        return $this;
    }

    public function getOwner(): ?User
    {
        return $this->Owner;
    }

    public function setOwner(?User $Owner): self
    {
        $this->Owner = $Owner;

        return $this;
    }
}
