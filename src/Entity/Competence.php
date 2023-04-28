<?php

namespace App\Entity;

use App\Repository\CompetenceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CompetenceRepository::class)
 */
class Competence
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
    private $nom;

    /**
     * @ORM\Column(type="boolean")
     */
    private $valide = false;


    /**
     * @ORM\ManyToOne(targetEntity=GroupeCompetence::class, inversedBy="competences")
     */
    private $groupeCompetence;

    /**
     * @ORM\OneToMany(targetEntity=Activite::class, mappedBy="competence")
     */
    private $activites;


    public function __construct()
    {
        $this->activites = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getGroupeCompetence(): ?GroupeCompetence
    {
        return $this->groupeCompetence;
    }

    public function setGroupeCompetence(?GroupeCompetence $groupeCompetence): self
    {
        $this->groupeCompetence = $groupeCompetence;

        return $this;
    }
    public function getValide()
    {
        return $this->valide;
    }

    public function setValide($valide): void
    {
        $this->valide = $valide;
    }

    public function __toString()
    {
        return $this->getNom();
    }

    /**
     * @return Collection<int, Activite>
     */
    public function getActivites(): Collection
    {
        return $this->activites;
    }

    public function addActivite(Activite $activite): self
    {
        if (!$this->activites->contains($activite)) {
            $this->activites[] = $activite;
            $activite->setCompetence($this);
        }

        return $this;
    }

    public function removeActivite(Activite $activite): self
    {
        if ($this->activites->removeElement($activite)) {
            // set the owning side to null (unless already changed)
            if ($activite->getCompetence() === $this) {
                $activite->setCompetence(null);
            }
        }

        return $this;
    }

}
