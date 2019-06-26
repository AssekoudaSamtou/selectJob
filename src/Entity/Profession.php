<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProfessionRepository")
 */
class Profession
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
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Particulier", mappedBy="profession")
     */
    private $particuliers;

    public function __construct()
    {
        $this->particuliers = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection|Particulier[]
     */
    public function getParticuliers(): Collection
    {
        return $this->particuliers;
    }

    public function addParticulier(Particulier $particulier): self
    {
        if (!$this->particuliers->contains($particulier)) {
            $this->particuliers[] = $particulier;
            $particulier->setProfession($this);
        }

        return $this;
    }

    public function removeParticulier(Particulier $particulier): self
    {
        if ($this->particuliers->contains($particulier)) {
            $this->particuliers->removeElement($particulier);
            // set the owning side to null (unless already changed)
            if ($particulier->getProfession() === $this) {
                $particulier->setProfession(null);
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
