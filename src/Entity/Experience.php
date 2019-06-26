<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ExperienceRepository")
 */
class Experience
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=500)
     */
    private $description;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Particulier", mappedBy="experiences")
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
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
            $particulier->addExperience($this);
        }

        return $this;
    }

    public function removeParticulier(Particulier $particulier): self
    {
        if ($this->particuliers->contains($particulier)) {
            $this->particuliers->removeElement($particulier);
            $particulier->removeExperience($this);
        }

        return $this;
    }

    /**
    * toString
    * @return string
    */
    public function __toString()
    {
       return $this->description;
    }
}
