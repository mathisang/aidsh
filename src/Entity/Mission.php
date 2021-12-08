<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\MissionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MissionRepository::class)
 */
#[ApiResource]
class Mission
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date_start;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="missionsClient")
     * @ORM\JoinColumn(nullable=false)
     */
    private $client;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $priority;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $date_realisation;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $status;

    /**
     * @ORM\ManyToMany(targetEntity=Vilain::class, inversedBy="missionsVilain")
     */
    private $vilain;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, inversedBy="missionsHero")
     */
    private $superhero;

    public function __construct()
    {
        $this->vilain = new ArrayCollection();
        $this->superhero = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getDateStart(): ?\DateTimeInterface
    {
        return $this->date_start;
    }

    public function setDateStart(\DateTimeInterface $date_start): self
    {
        $this->date_start = $date_start;

        return $this;
    }

    public function getClient(): ?User
    {
        return $this->client;
    }

    public function setClient(?User $client): self
    {
        $this->client = $client;

        return $this;
    }

    public function getPriority(): ?string
    {
        return $this->priority;
    }

    public function setPriority(string $priority): self
    {
        $this->priority = $priority;

        return $this;
    }

    public function getDateRealisation(): ?\DateTimeInterface
    {
        return $this->date_realisation;
    }

    public function setDateRealisation(\DateTimeInterface $date_realisation): self
    {
        $this->date_realisation = $date_realisation;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return Collection|Vilain[]
     */
    public function getVilain(): Collection
    {
        return $this->vilain;
    }

    public function addVilain(Vilain $vilain): self
    {
        if (!$this->vilain->contains($vilain)) {
            $this->vilain[] = $vilain;
        }

        return $this;
    }

    public function removeVilain(Vilain $vilain): self
    {
        $this->vilain->removeElement($vilain);

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getSuperhero(): Collection
    {
        return $this->superhero;
    }

    public function addSuperhero(User $superhero): self
    {
        if (!$this->superhero->contains($superhero)) {
            $this->superhero[] = $superhero;
        }

        return $this;
    }

    public function removeSuperhero(User $superhero): self
    {
        $this->superhero->removeElement($superhero);

        return $this;
    }
}
