<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\NiveauRepository")
 */
class Niveau
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
    private $libelle;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\CompetenceOffre", mappedBy="niveau")
     */
    private $competenceOffres;

    public function __construct()
    {
        $this->competenceOffres = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

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
            $competenceOffre->setNiveau($this);
        }

        return $this;
    }

    public function removeCompetenceOffre(CompetenceOffre $competenceOffre): self
    {
        if ($this->competenceOffres->contains($competenceOffre)) {
            $this->competenceOffres->removeElement($competenceOffre);
            // set the owning side to null (unless already changed)
            if ($competenceOffre->getNiveau() === $this) {
                $competenceOffre->setNiveau(null);
            }
        }

        return $this;
    }

    /**
    * toString
    * @return string
    */
    public function __toString()
    {
       return $this->libelle;
    }
}
