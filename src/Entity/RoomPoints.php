<?php

namespace App\Entity;

use App\Repository\RoomPointsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RoomPointsRepository::class)
 */
class RoomPoints
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $Latitude;

    /**
     * @ORM\Column(type="integer")
     */
    private $Longitude;

    /**
     * @ORM\Column(type="integer")
     */
    private $Altitude;

    /**
     * @ORM\ManyToOne(targetEntity=Room::class, inversedBy="roomPoints")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Room;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLatitude(): ?int
    {
        return $this->Latitude;
    }

    public function setLatitude(int $Latitude): self
    {
        $this->Latitude = $Latitude;

        return $this;
    }

    public function getLongitude(): ?int
    {
        return $this->Longitude;
    }

    public function setLongitude(int $Longitude): self
    {
        $this->Longitude = $Longitude;

        return $this;
    }

    public function getAltitude(): ?int
    {
        return $this->Altitude;
    }

    public function setAltitude(int $Altitude): self
    {
        $this->Altitude = $Altitude;

        return $this;
    }

    public function getRoom(): ?Room
    {
        return $this->Room;
    }

    public function setRoom(?Room $Room): self
    {
        $this->Room = $Room;

        return $this;
    }
}
