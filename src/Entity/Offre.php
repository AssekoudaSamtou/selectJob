<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\OffreRepository")
 */
class Offre
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
     * @ORM\ManyToOne(targetEntity="App\Entity\CategorieOffre", inversedBy="offres")
     */
    private $categorie;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $nbExperience;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $telephone;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $remuneration;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $duree;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $finDemande;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\CompetenceOffre", mappedBy="offre", orphanRemoval=true)
     */
    private $competenceOffres;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Particulier", inversedBy="offres")
     */
    private $postulants;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Entreprise", inversedBy="offres")
     * @ORM\JoinColumn(nullable=false)
     */
    private $auteur;


    public function __construct()
    {
        $this->competenceOffres = new ArrayCollection();
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

    public function getCategorie(): ?CategorieOffre
    {
        return $this->categorie;
    }

    public function setCategorie(?CategorieOffre $categorie): self
    {
        $this->categorie = $categorie;

        return $this;
    }

    public function getNbExperience(): ?int
    {
        return $this->nbExperience;
    }

    public function setNbExperience(int $nbExperience): self
    {
        $this->nbExperience = $nbExperience;

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getRemuneration(): ?float
    {
        return $this->remuneration;
    }

    public function setRemuneration(float $remuneration): self
    {
        $this->remuneration = $remuneration;

        return $this;
    }

    public function getDuree(): ?int
    {
        return $this->duree;
    }

    public function setDuree(?int $duree): self
    {
        $this->duree = $duree;

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

    /**
     * @return Collection|CompetenceOffre[]
     */
    public function getCompetenceOffres(): Collection
    {
        return $this->competenceOffres;
    }

    public function addCompetenceOffre(CompetenceOffre $competenceOffre): self
    {
        if (!$this->competenceOffres->contains($competenceOffre)) {
            $this->competenceOffres[] = $competenceOffre;
            $competenceOffre->setOffre($this);
        }

        return $this;
    }

    public function removeCompetenceOffre(CompetenceOffre $competenceOffre): self
    {
        if ($this->competenceOffres->contains($competenceOffre)) {
            $this->competenceOffres->removeElement($competenceOffre);
            // set the owning side to null (unless already changed)
            if ($competenceOffre->getOffre() === $this) {
                $competenceOffre->setOffre(null);
            }
        }

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
}
