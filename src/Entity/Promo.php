<?php

namespace App\Entity;

use App\Repository\PromoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Eleve;

/**
 * @ORM\Entity(repositoryClass=PromoRepository::class)
 */
class Promo
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
     * @ORM\Column(type="string", length=255)
     */
    private $date;

    /**
     * @ORM\OneToMany(targetEntity=User1::class, mappedBy="promo")
     */
    private $user1s;

    public function __construct()
    {
        $this->eleves = new ArrayCollection();
        $this->user1s = new ArrayCollection();
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

    public function getDate(): ?string
    {
        return $this->date;
    }

    public function setDate(string $date): self
    {
        $this->date = $date;

        return $this;
    }

    /**
     * @return Collection<int, User1>
     */
    public function getEleves(): Collection
    {
        return $this->eleves;
    }

    public function addElefe(User1 $elefe): self
    {
        if (!$this->eleves->contains($elefe)) {
            $this->eleves[] = $elefe;
            $elefe->setPromo($this);
        }

        return $this;
    }

    public function removeElefe(User1 $elefe): self
    {
        if ($this->eleves->removeElement($elefe)) {
            // set the owning side to null (unless already changed)
            if ($elefe->getPromo() === $this) {
                $elefe->setPromo(null);
            }
        }

        return $this;
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
            $user1->setPromo($this);
        }

        return $this;
    }

    public function removeUser1(User1 $user1): self
    {
        if ($this->user1s->removeElement($user1)) {
            // set the owning side to null (unless already changed)
            if ($user1->getPromo() === $this) {
                $user1->setPromo(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->getNom();
    }

}
