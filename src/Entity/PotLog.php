<?php

namespace App\Entity;

use App\Repository\PotLogRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PotLogRepository::class)
 */
class PotLog
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
    private $Humidity;

    /**
     * @ORM\Column(type="integer")
     */
    private $Temperature;

    /**
     * @ORM\Column(type="integer")
     */
    private $SoilMoistureTop;

    /**
     * @ORM\Column(type="integer")
     */
    private $SoilMoistureMiddel;

    /**
     * @ORM\Column(type="integer")
     */
    private $SoilMoistureBottom;

    /**
     * @ORM\Column(type="integer")
     */
    private $PH;

    /**
     * @ORM\Column(type="integer")
     */
    private $Resevoir;

    /**
     * @ORM\ManyToOne(targetEntity=Pot::class, inversedBy="potLogs")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Pot;

    /**
     * @ORM\Column(type="datetime")
     */
    private $addedDate;

    /**
     * @ORM\Column(type="integer")
     */
    private $Luminosity1;

    /**
     * @ORM\Column(type="integer")
     */
    private $Luminosity2;

    /**
     * @ORM\Column(type="integer")
     */
    private $Luminosity3;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getHumidity(): ?int
    {
        return $this->Humidity;
    }

    public function setHumidity(int $Humidity): self
    {
        $this->Humidity = $Humidity;

        return $this;
    }

    public function getTemperature(): ?int
    {
        return $this->Temperature;
    }

    public function setTemperature(int $Temperature): self
    {
        $this->Temperature = $Temperature;

        return $this;
    }

    public function getSoilMoistureTop(): ?int
    {
        return $this->SoilMoistureTop;
    }

    public function setSoilMoistureTop(int $SoilMoistureTop): self
    {
        $this->SoilMoistureTop = $SoilMoistureTop;

        return $this;
    }

    public function getSoilMoistureMiddel(): ?int
    {
        return $this->SoilMoistureMiddel;
    }

    public function setSoilMoistureMiddel(int $SoilMoistureMiddel): self
    {
        $this->SoilMoistureMiddel = $SoilMoistureMiddel;

        return $this;
    }

    public function getSoilMoistureBottom(): ?int
    {
        return $this->SoilMoistureBottom;
    }

    public function setSoilMoistureBottom(int $SoilMoistureBottom): self
    {
        $this->SoilMoistureBottom = $SoilMoistureBottom;

        return $this;
    }

    public function getPH(): ?int
    {
        return $this->PH;
    }

    public function setPH(int $PH): self
    {
        $this->PH = $PH;

        return $this;
    }

    public function getResevoir(): ?int
    {
        return $this->Resevoir;
    }

    public function setResevoir(int $Resevoir): self
    {
        $this->Resevoir = $Resevoir;

        return $this;
    }

    public function getPot(): ?Pot
    {
        return $this->Pot;
    }

    public function setPot(?Pot $Pot): self
    {
        $this->Pot = $Pot;

        return $this;
    }

    public function getAddedDate(): ?\DateTimeInterface
    {
        return $this->addedDate;
    }

    public function setAddedDate(\DateTimeInterface $addedDate): self
    {
        $this->addedDate = $addedDate;

        return $this;
    }

    public function getLuminosity1(): ?int
    {
        return $this->Luminosity1;
    }

    public function setLuminosity1(int $Luminosity1): self
    {
        $this->Luminosity1 = $Luminosity1;

        return $this;
    }

    public function getLuminosity2(): ?int
    {
        return $this->Luminosity2;
    }

    public function setLuminosity2(int $Luminosity2): self
    {
        $this->Luminosity2 = $Luminosity2;

        return $this;
    }

    public function getLuminosity3(): ?int
    {
        return $this->Luminosity3;
    }

    public function setLuminosity3(int $Luminosity3): self
    {
        $this->Luminosity3 = $Luminosity3;

        return $this;
    }
}
