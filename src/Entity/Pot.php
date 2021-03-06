<?php

namespace App\Entity;

use App\Helpers\QRHelper;
use App\Repository\PotRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=PotRepository::class)
 */
class Pot implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $uuid;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="pot")
     */
    private $Owner;

    /**
     * @ORM\OneToMany(targetEntity=PotLog::class, mappedBy="Pot")
     */
    private $potLogs;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $url;

    public function __construct()
    {
        $this->potLogs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUuid(): ?string
    {
        return $this->uuid;
    }

    public function setUuid(string $uuid): self
    {
        $this->uuid = $uuid;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->uuid;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_API';

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

    public function getOwner(): ?User
    {
        return $this->Owner;
    }

    public function setOwner(?UserInterface $Owner): self
    {
        $this->Owner = $Owner;

        return $this;
    }

    /**
     * @return Collection|PotLog[]
     */
    public function getPotLogs(): Collection
    {
        return $this->potLogs;
    }

    /**
     * @return PotLog|null
     */
    public function getLatestPotLog(){
        $collection = $this->getPotLogs();
        if (count($collection) > 0){
            return $collection[(count($collection) -1)];
        }
        return new PotLog();
    }

    public function addPotLog(PotLog $potLog): self
    {
        if (!$this->potLogs->contains($potLog)) {
            $this->potLogs[] = $potLog;
            $potLog->setPot($this);
        }

        return $this;
    }

    public function removePotLog(PotLog $potLog): self
    {
        if ($this->potLogs->removeElement($potLog)) {
            // set the owning side to null (unless already changed)
            if ($potLog->getPot() === $this) {
                $potLog->setPot(null);
            }
        }

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

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $Url): self
    {
        $this->url = $Url;

        return $this;
    }

    public function supportsClass(){
        return true;
    }

    public function getQrCode(){
        return QRHelper::Create($this->getUuid());
    }
}
