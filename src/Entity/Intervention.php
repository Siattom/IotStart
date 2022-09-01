<?php

namespace App\Entity;

use App\Repository\InterventionRepository;
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
     * @ORM\Column(type="integer")
     */
    private $n°ot;

    /**
     * @ORM\Column(type="text")
     */
    private $Description;

    /**
     * @ORM\Column(type="datetime", nullable=true)
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

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getN°ot(): ?int
    {
        return $this->n°ot;
    }

    public function setN°ot(int $n°ot): self
    {
        $this->n°ot = $n°ot;

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

    public function setStartWork(?\DateTimeInterface $Start_work): self
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
}
