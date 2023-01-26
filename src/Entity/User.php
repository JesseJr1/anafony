<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    private ?string $roles = null;

    #[ORM\Column(length: 255)]
    private ?string $password = null;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Rate::class, orphanRemoval: true)]
    private Collection $userRates;

    public function __construct()
    {
        $this->userRates = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getRoles(): ?string
    {
        return $this->roles;
    }

    public function setRoles(string $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @return Collection<int, Rate>
     */
    public function getUserRates(): Collection
    {
        return $this->userRates;
    }

    public function addUserRate(Rate $userRate): self
    {
        if (!$this->userRates->contains($userRate)) {
            $this->userRates->add($userRate);
            $userRate->setUser($this);
        }

        return $this;
    }

    public function removeUserRate(Rate $userRate): self
    {
        if ($this->userRates->removeElement($userRate)) {
            // set the owning side to null (unless already changed)
            if ($userRate->getUser() === $this) {
                $userRate->setUser(null);
            }
        }

        return $this;
    }
}
