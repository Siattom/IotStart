<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @UniqueEntity(fields={"Email"}, message="There is already an account with this Email")
 */
class User implements UserInterface, PasswordAuthenticatedUserInterface
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
    private $Surname;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Password;

     /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $Created_at;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $Updated_at;

    /**
     * @ORM\OneToMany(targetEntity=Securite::class, mappedBy="user")
     */
    private $securites;

    /**
     * @ORM\ManyToMany(targetEntity=Operateur::class, inversedBy="users")
     */
    private $Operateur;

    public function __construct()
    {
        $this->securites = new ArrayCollection();
        $this->Operateur = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSurname(): ?string
    {
        return $this->Surname;
    }

    public function setSurname(string $Surname): self
    {
        $this->Surname = $Surname;

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

    public function getEmail(): ?string
    {
        return $this->Email;
    }

    public function setEmail(string $Email): self
    {
        $this->Email = $Email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->Password;
    }

    public function setPassword(string $Password): self
    {
        $this->Password = $Password;

        return $this;
    }

    public function getRoles(): array
    {
        $roles = $this->roles;
    
        return array_unique($roles);
    }
    
    public function setRoles(array $roles): self
    {
        $this->roles = $roles;
    
        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->Created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $Created_at): self
    {
        $this->Created_at = $Created_at;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->Updated_at;
    }

    public function setUpdatedAt(?\DateTimeInterface $Updated_at): self
    {
        $this->Updated_at = $Updated_at;

        return $this;
    }

    public function eraseCredentials()
    {
    }

    public function getSalt()
    {
    }
    
    public function getUserIdentifier(): ?string
    {
        return $this->Email;
    }

    public function getUsername()
    {
        return $this->Email;
    }

    /**
     * @return Collection<int, Securite>
     */
    public function getSecurites(): Collection
    {
        return $this->securites;
    }

    public function addSecurite(Securite $securite): self
    {
        if (!$this->securites->contains($securite)) {
            $this->securites[] = $securite;
            $securite->setUser($this);
        }

        return $this;
    }

    public function removeSecurite(Securite $securite): self
    {
        if ($this->securites->removeElement($securite)) {
            // set the owning side to null (unless already changed)
            if ($securite->getUser() === $this) {
                $securite->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Operateur>
     */
    public function getOperateur(): Collection
    {
        return $this->Operateur;
    }

    public function addOperateur(Operateur $operateur): self
    {
        if (!$this->Operateur->contains($operateur)) {
            $this->Operateur[] = $operateur;
        }

        return $this;
    }

    public function removeOperateur(Operateur $operateur): self
    {
        $this->Operateur->removeElement($operateur);

        return $this;
    }
}
