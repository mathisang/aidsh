<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ORM\Table(name="`user`")
 */
#[ApiResource]
class User implements UserInterface, PasswordAuthenticatedUserInterface
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
    private $username;

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
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $publisher;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $image;

    /**
     * @ORM\OneToMany(targetEntity=Mission::class, mappedBy="client")
     */
    private $missionsClient;

    /**
     * @ORM\ManyToMany(targetEntity=Mission::class, mappedBy="superhero")
     */
    private $missionsHero;

    public function __toString()
    {
        return $this->username;
    }

    public function __construct()
    {
        $this->missionsClient = new ArrayCollection();
        $this->missionsHero = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): string
    {
        return (string) $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->username;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getPublisher(): ?string
    {
        return $this->publisher;
    }

    public function setPublisher(?string $publisher): self
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
    public function getMissionsClient(): Collection
    {
        return $this->missionsClient;
    }

    public function addMissionsClient(Mission $missionsClient): self
    {
        if (!$this->missionsClient->contains($missionsClient)) {
            $this->missionsClient[] = $missionsClient;
            $missionsClient->setClient($this);
        }

        return $this;
    }

    public function removeMissionsClient(Mission $missionsClient): self
    {
        if ($this->missionsClient->removeElement($missionsClient)) {
            // set the owning side to null (unless already changed)
            if ($missionsClient->getClient() === $this) {
                $missionsClient->setClient(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Mission[]
     */
    public function getMissionsHero(): Collection
    {
        return $this->missionsHero;
    }

    public function addMissionsHero(Mission $missionsHero): self
    {
        if (!$this->missionsHero->contains($missionsHero)) {
            $this->missionsHero[] = $missionsHero;
            $missionsHero->addSuperhero($this);
        }

        return $this;
    }

    public function removeMissionsHero(Mission $missionsHero): self
    {
        if ($this->missionsHero->removeElement($missionsHero)) {
            $missionsHero->removeSuperhero($this);
        }

        return $this;
    }
}
