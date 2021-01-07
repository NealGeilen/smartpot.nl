<?php

namespace App\Entity;

use App\Repository\RoomRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RoomRepository::class)
 */
class Room
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="rooms")
     */
    private $Owner;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Name;

    /**
     * @ORM\OneToMany(targetEntity=RoomPoints::class, mappedBy="Room")
     */
    private $roomPoints;

    public function __construct()
    {
        $this->roomPoints = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getName(): ?string
    {
        return $this->Name;
    }

    public function setName(string $Name): self
    {
        $this->Name = $Name;

        return $this;
    }

    /**
     * @return Collection|RoomPoints[]
     */
    public function getRoomPoints(): Collection
    {
        return $this->roomPoints;
    }

    public function addRoomPoint(RoomPoints $roomPoint): self
    {
        if (!$this->roomPoints->contains($roomPoint)) {
            $this->roomPoints[] = $roomPoint;
            $roomPoint->setRoom($this);
        }

        return $this;
    }

    public function removeRoomPoint(RoomPoints $roomPoint): self
    {
        if ($this->roomPoints->removeElement($roomPoint)) {
            // set the owning side to null (unless already changed)
            if ($roomPoint->getRoom() === $this) {
                $roomPoint->setRoom(null);
            }
        }

        return $this;
    }
}
