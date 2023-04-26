<?php

namespace App\Entity;

use App\Repository\EleveRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=EleveRepository::class)
 */
class Eleve extends User1
{
    /**
     * @ORM\Column(type="string", length=255)
     */
    private $option;

    /**
     * @ORM\ManyToOne(targetEntity=Promo::class, inversedBy="eleves")
     */
    private $promo;

    /**
     * @ORM\ManyToOne(targetEntity=Portefeuille::class, inversedBy="eleves")
     */
    private $portefeuille;

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

    public function getPortefeuille(): ?Portefeuille
    {
        return $this->portefeuille;
    }

    public function setPortefeuille(?Portefeuille $portefeuille): self
    {
        $this->portefeuille = $portefeuille;

        return $this;
    }
}
