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
     * @ORM\ManyToMany(targetEntity=Situation::class, mappedBy="competences")
     */
    private $situations;

    public function __construct()
    {
        $this->situations = new ArrayCollection();
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
     * @return Collection<int, Situation>
     */
    public function getSituations(): Collection
    {
        return $this->situations;
    }

    public function addSituation(Situation $situation): self
    {
        if (!$this->situations->contains($situation)) {
            $this->situations[] = $situation;
            $situation->addCompetence($this);
        }

        return $this;
    }

    public function removeSituation(Situation $situation): self
    {
        if ($this->situations->removeElement($situation)) {
            $situation->removeCompetence($this);
        }

        return $this;
    }


}
