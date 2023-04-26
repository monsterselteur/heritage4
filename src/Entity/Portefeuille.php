<?php

namespace App\Entity;

use App\Repository\PortefeuilleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PortefeuilleRepository::class)
 */
class Portefeuille
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity=GroupeCompetence::class, mappedBy="portefeuille")
     */
    private $groupeCompetences;

    /**
     * @ORM\OneToMany(targetEntity=User1::class, mappedBy="portefeuille")
     */
    private $user1s;

    public function __construct()
    {
        $this->groupeCompetences = new ArrayCollection();
        $this->user1s = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, GroupeCompetence>
     */
    public function getGroupeCompetences(): Collection
    {
        return $this->groupeCompetences;
    }

    public function addGroupeCompetence(GroupeCompetence $groupeCompetence): self
    {
        if (!$this->groupeCompetences->contains($groupeCompetence)) {
            $this->groupeCompetences[] = $groupeCompetence;
            $groupeCompetence->setPortefeuille($this);
        }

        return $this;
    }

    public function removeGroupeCompetence(GroupeCompetence $groupeCompetence): self
    {
        if ($this->groupeCompetences->removeElement($groupeCompetence)) {
            // set the owning side to null (unless already changed)
            if ($groupeCompetence->getPortefeuille() === $this) {
                $groupeCompetence->setPortefeuille(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->getId()."";
    }

    /**
     * @return Collection<int, User1>
     */
    public function getUser1s(): Collection
    {
        return $this->user1s;
    }

    public function addUser1(User1 $user1): self
    {
        if (!$this->user1s->contains($user1)) {
            $this->user1s[] = $user1;
            $user1->setPortefeuille($this);
        }

        return $this;
    }

    public function removeUser1(User1 $user1): self
    {
        if ($this->user1s->removeElement($user1)) {
            // set the owning side to null (unless already changed)
            if ($user1->getPortefeuille() === $this) {
                $user1->setPortefeuille(null);
            }
        }

        return $this;
    }
}
