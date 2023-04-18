<?php

namespace App\Entity;

use App\Repository\EleveRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EleveRepository::class)
 */
class Eleve extends User
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $option;

    /**
     * @ORM\ManyToOne(targetEntity=Promo::class, inversedBy="eleves")
     */
    private $promo;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOption(): ?string
    {
        return $this->option;
    }

    public function setOption(string $option): self
    {
        $this->option = $option;

        return $this;
    }

    public function getPromo(): ?Promo
    {
        return $this->promo;
    }

    public function setPromo(?Promo $promo): self
    {
        $this->promo = $promo;

        return $this;
    }
}
