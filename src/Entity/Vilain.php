<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\VilainRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=VilainRepository::class)
 */
#[ApiResource]
class Vilain
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
    private $publisher;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $image;

    /**
     * @ORM\ManyToMany(targetEntity=Mission::class, mappedBy="vilain")
     */
    private $missionsVilain;

    public function __toString()
    {
        return $this->name;
    }

    public function __construct()
    {
        $this->missionsVilain = new ArrayCollection();
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

    public function getPublisher(): ?string
    {
        return $this->publisher;
    }

    public function setPublisher(string $publisher): self
    {
        $this->publisher = $publisher;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    /**
     * @return Collection|Mission[]
     */
    public function getMissionsVilain(): Collection
    {
        return $this->missionsVilain;
    }

    public function addMissionsVilain(Mission $missionsVilain): self
    {
        if (!$this->missionsVilain->contains($missionsVilain)) {
            $this->missionsVilain[] = $missionsVilain;
            $missionsVilain->addVilain($this);
        }

        return $this;
    }

    public function removeMissionsVilain(Mission $missionsVilain): self
    {
        if ($this->missionsVilain->removeElement($missionsVilain)) {
            $missionsVilain->removeVilain($this);
        }

        return $this;
    }
}
