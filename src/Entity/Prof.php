<?php

namespace App\Entity;

use App\Repository\ProfRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=ProfRepository::class)
 */
class Prof extends User1
{

}
