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

    /**
     * @ORM\Column(type="text")
     */
    private $content;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $created_at;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updated_at;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(?\DateTimeInterface $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }
}
