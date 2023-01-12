<?php

namespace App\Entity;

use App\Repository\VisiteTechniqueRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=VisiteTechniqueRepository::class)
 */
class VisiteTechnique
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
    private $travaux_a_effectuer;

    /**
     * @ORM\Column(type="text")
     */
    private $materiel_necessaire;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $activite;

    /**
     * @ORM\Column(type="integer")
     */
    private $temps_necessaire;

    /**
     * @ORM\Column(type="integer")
     */
    private $difficulte;

    /**
     * @ORM\Column(type="text")
     */
    private $commentaire;

    /**
     * @ORM\Column(type="text")
     */
    private $personne_a_contacter;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $solution_1;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $solution_2;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $solution_3;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $date_de_disponibilite;

    /**
     * @ORM\Column(type="text")
     */
    private $moyen_de_securite;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $adresse;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\Column(type="integer")
     */
    private $telephone;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $adresse_mail;

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

    public function getTravauxAEffectuer(): ?string
    {
        return $this->travaux_a_effectuer;
    }

    public function setTravauxAEffectuer(string $travaux_a_effectuer): self
    {
        $this->travaux_a_effectuer = $travaux_a_effectuer;

        return $this;
    }

    public function getMaterielNecessaire(): ?string
    {
        return $this->materiel_necessaire;
    }

    public function setMaterielNecessaire(string $materiel_necessaire): self
    {
        $this->materiel_necessaire = $materiel_necessaire;

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

    public function getTempsNecessaire(): ?int
    {
        return $this->temps_necessaire;
    }

    public function setTempsNecessaire(int $temps_necessaire): self
    {
        $this->temps_necessaire = $temps_necessaire;

        return $this;
    }

    public function getDifficulte(): ?int
    {
        return $this->difficulte;
    }

    public function setDifficulte(int $difficulte): self
    {
        $this->difficulte = $difficulte;

        return $this;
    }

    public function getCommentaire(): ?string
    {
        return $this->commentaire;
    }

    public function setCommentaire(string $commentaire): self
    {
        $this->commentaire = $commentaire;

        return $this;
    }

    public function getPersonneAContacter(): ?string
    {
        return $this->personne_a_contacter;
    }

    public function setPersonneAContacter(string $personne_a_contacter): self
    {
        $this->personne_a_contacter = $personne_a_contacter;

        return $this;
    }

    public function getSolution1(): ?string
    {
        return $this->solution_1;
    }

    public function setSolution1(?string $solution_1): self
    {
        $this->solution_1 = $solution_1;

        return $this;
    }

    public function getSolution2(): ?string
    {
        return $this->solution_2;
    }

    public function setSolution2(?string $solution_2): self
    {
        $this->solution_2 = $solution_2;

        return $this;
    }

    public function getSolution3(): ?string
    {
        return $this->solution_3;
    }

    public function setSolution3(?string $solution_3): self
    {
        $this->solution_3 = $solution_3;

        return $this;
    }

    public function getDateDeDisponibilite(): ?\DateTimeInterface
    {
        return $this->date_de_disponibilite;
    }

    public function setDateDeDisponibilite(?\DateTimeInterface $date_de_disponibilite): self
    {
        $this->date_de_disponibilite = $date_de_disponibilite;

        return $this;
    }

    public function getMoyenDeSecurite(): ?string
    {
        return $this->moyen_de_securite;
    }

    public function setMoyenDeSecurite(string $moyen_de_securite): self
    {
        $this->moyen_de_securite = $moyen_de_securite;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getTelephone(): ?int
    {
        return $this->telephone;
    }

    public function setTelephone(int $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getAdresseMail(): ?string
    {
        return $this->adresse_mail;
    }

    public function setAdresseMail(string $adresse_mail): self
    {
        $this->adresse_mail = $adresse_mail;

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
