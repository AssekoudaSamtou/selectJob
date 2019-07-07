<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FormationRepository")
 */
class Formation
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $titre;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Localisation", inversedBy="formations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $lieu;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Prerequis", inversedBy="formations")
     */
    private $Prerequis;

    /**
     * @ORM\Column(type="float")
     */
    private $fraisInscription;

    /**
     * @ORM\Column(type="float")
     */
    private $fraisFormation;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $finDemande;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $telephone;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Particulier", inversedBy="formations")
     */
    private $postulants;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Entreprise", inversedBy="formations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $auteur;

    /**
     * @ORM\Column(type="string", length=500)
     */
    private $description;

    public function __construct()
    {
        $this->Prerequis = new ArrayCollection();
        $this->postulants = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getLieu(): ?Localisation
    {
        return $this->lieu;
    }

    public function setLieu(?Localisation $lieu): self
    {
        $this->lieu = $lieu;

        return $this;
    }

    /**
     * @return Collection|Prerequis[]
     */
    public function getPrerequis(): Collection
    {
        return $this->Prerequis;
    }

    public function emptyPrerequis(): self
    {
        $this->Prerequis = new ArrayCollection();
        
        return $this;
    }

    public function addPrerequi(Prerequis $prerequi): self
    {
        if (!$this->Prerequis->contains($prerequi)) {
            $this->Prerequis[] = $prerequi;
        }

        return $this;
    }

    public function removePrerequi(Prerequis $prerequi): self
    {
        if ($this->Prerequis->contains($prerequi)) {
            $this->Prerequis->removeElement($prerequi);
        }

        return $this;
    }

    public function getFraisInscription(): ?float
    {
        return $this->fraisInscription;
    }

    public function setFraisInscription(float $fraisInscription): self
    {
        $this->fraisInscription = $fraisInscription;

        return $this;
    }

    public function getFraisFormation(): ?float
    {
        return $this->fraisFormation;
    }

    public function setFraisFormation(float $fraisFormation): self
    {
        $this->fraisFormation = $fraisFormation;

        return $this;
    }

    public function getFinDemande(): ?\DateTimeInterface
    {
        return $this->finDemande;
    }

    public function setFinDemande(\DateTimeInterface $finDemande): self
    {
        $this->finDemande = $finDemande;

        return $this;
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

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(?string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    /**
     * @return Collection|Particulier[]
     */
    public function getPostulants(): Collection
    {
        return $this->postulants;
    }

    public function addPostulant(Particulier $postulant): self
    {
        if (!$this->postulants->contains($postulant)) {
            $this->postulants[] = $postulant;
        }

        return $this;
    }

    public function removePostulant(Particulier $postulant): self
    {
        if ($this->postulants->contains($postulant)) {
            $this->postulants->removeElement($postulant);
        }

        return $this;
    }

    public function getAuteur(): ?Entreprise
    {
        return $this->auteur;
    }

    public function setAuteur(?Entreprise $auteur): self
    {
        $this->auteur = $auteur;

        return $this;
    }

    /**
    * toString
    * @return string
    */
    public function __toString()
    {
       return $this->titre;
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

    public function isSuscribed(Particulier $postulant)
    {
        if ($this->postulants->contains($postulant)) {
            return true;
        }
        return false;
    }
}
