<?php

namespace App\Entity;

use App\Repository\InterventionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=InterventionRepository::class)
 */
class Intervention
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
    private $Name;

    /**
     * @ORM\Column(type="text")
     */
    private $Description;

    /**
     * @ORM\Column(type="datetime")
     */
    private $Start_work;

    /**
     * @ORM\Column(type="boolean")
     */
    private $Cloture;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $Cloture_finale;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $Created_at;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $Updated_at;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Adresse;

    /**
     * @ORM\OneToMany(targetEntity=Rapport::class, mappedBy="intervention")
     */
    private $rapports;

    /**
     * @ORM\ManyToOne(targetEntity=Operateur::class, inversedBy="interventions")
     */
    private $operateur;

    /**
     * @ORM\ManyToOne(targetEntity=Client::class, inversedBy="interventions")
     */
    private $client;

    /**
     * @ORM\OneToMany(targetEntity=VisiteTechnique::class, mappedBy="intervention")
     */
    private $visite;

    /**
     * @ORM\Column(type="integer")
     */
    private $numero_ot;

    public function __construct()
    {
        $this->rapports = new ArrayCollection();
        $this->visite = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getDescription(): ?string
    {
        return $this->Description;
    }

    public function setDescription(string $Description): self
    {
        $this->Description = $Description;

        return $this;
    }

    public function getStartWork(): ?\DateTimeInterface
    {
        return $this->Start_work;
    }

    public function setStartWork(\DateTimeInterface $Start_work): self
    {
        $this->Start_work = $Start_work;

        return $this;
    }

    public function isCloture(): ?bool
    {
        return $this->Cloture;
    }

    public function setCloture(bool $Cloture): self
    {
        $this->Cloture = $Cloture;

        return $this;
    }

    public function getClotureFinale(): ?\DateTimeInterface
    {
        return $this->Cloture_finale;
    }

    public function setClotureFinale(?\DateTimeInterface $Cloture_finale): self
    {
        $this->Cloture_finale = $Cloture_finale;

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

    public function getAdresse(): ?string
    {
        return $this->Adresse;
    }

    public function setAdresse(string $Adresse): self
    {
        $this->Adresse = $Adresse;

        return $this;
    }

    /**
     * @return Collection<int, Rapport>
     */
    public function getRapports(): Collection
    {
        return $this->rapports;
    }

    public function addRapport(Rapport $rapport): self
    {
        if (!$this->rapports->contains($rapport)) {
            $this->rapports[] = $rapport;
            $rapport->setIntervention($this);
        }

        return $this;
    }

    public function removeRapport(Rapport $rapport): self
    {
        if ($this->rapports->removeElement($rapport)) {
            // set the owning side to null (unless already changed)
            if ($rapport->getIntervention() === $this) {
                $rapport->setIntervention(null);
            }
        }

        return $this;
    }

    public function getOperateur(): ?Operateur
    {
        return $this->operateur;
    }

    public function setOperateur(?Operateur $operateur): self
    {
        $this->operateur = $operateur;

        return $this;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): self
    {
        $this->client = $client;

        return $this;
    }

    /**
     * @return Collection<int, VisiteTechnique>
     */
    public function getVisite(): Collection
    {
        return $this->visite;
    }

    public function addVisite(VisiteTechnique $visite): self
    {
        if (!$this->visite->contains($visite)) {
            $this->visite[] = $visite;
            $visite->setIntervention($this);
        }

        return $this;
    }

    public function removeVisite(VisiteTechnique $visite): self
    {
        if ($this->visite->removeElement($visite)) {
            // set the owning side to null (unless already changed)
            if ($visite->getIntervention() === $this) {
                $visite->setIntervention(null);
            }
        }

        return $this;
    }

    public function getNumeroOt(): ?int
    {
        return $this->numero_ot;
    }

    public function setNumeroOt(int $numero_ot): self
    {
        $this->numero_ot = $numero_ot;

        return $this;
    }
}
