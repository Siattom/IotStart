<?php

namespace App\Entity;

use App\Repository\RapportRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RapportRepository::class)
 */
class Rapport
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $Content;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $Created_at;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $Updated_at;

    /**
     * @ORM\ManyToOne(targetEntity=Intervention::class, inversedBy="rapports")
     */
    private $intervention;

    /**
     * @ORM\ManyToOne(targetEntity=Operateur::class, inversedBy="rapports")
     */
    private $operateur;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $activite;

    /**
     * @ORM\Column(type="text")
     */
    private $realisation_des_travaux;

    /**
     * @ORM\Column(type="boolean")
     */
    private $fonctionnement_apres_intervention;

    /**
     * @ORM\Column(type="text")
     */
    private $equipement_installe;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $numero_telephone_client;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $adresse_mail_client;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContent(): ?string
    {
        return $this->Content;
    }

    public function setContent(string $Content): self
    {
        $this->Content = $Content;

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

    public function getIntervention(): ?Intervention
    {
        return $this->intervention;
    }

    public function setIntervention(?Intervention $intervention): self
    {
        $this->intervention = $intervention;

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

    public function getActivite(): ?string
    {
        return $this->activite;
    }

    public function setActivite(string $activite): self
    {
        $this->activite = $activite;

        return $this;
    }

    public function getRealisationDesTravaux(): ?string
    {
        return $this->realisation_des_travaux;
    }

    public function setRealisationDesTravaux(string $realisation_des_travaux): self
    {
        $this->realisation_des_travaux = $realisation_des_travaux;

        return $this;
    }

    public function isFonctionnementApresIntervention(): ?bool
    {
        return $this->fonctionnement_apres_intervention;
    }

    public function setFonctionnementApresIntervention(bool $fonctionnement_apres_intervention): self
    {
        $this->fonctionnement_apres_intervention = $fonctionnement_apres_intervention;

        return $this;
    }

    public function getEquipementInstalle(): ?string
    {
        return $this->equipement_installe;
    }

    public function setEquipementInstalle(string $equipement_installe): self
    {
        $this->equipement_installe = $equipement_installe;

        return $this;
    }

    public function getNumeroTelephoneClient(): ?int
    {
        return $this->numero_telephone_client;
    }

    public function setNumeroTelephoneClient(?int $numero_telephone_client): self
    {
        $this->numero_telephone_client = $numero_telephone_client;

        return $this;
    }

    public function getAdresseMailClient(): ?string
    {
        return $this->adresse_mail_client;
    }

    public function setAdresseMailClient(?string $adresse_mail_client): self
    {
        $this->adresse_mail_client = $adresse_mail_client;

        return $this;
    }
}
