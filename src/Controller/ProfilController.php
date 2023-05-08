<?php

namespace App\Controller;

use App\Repository\EleveRepository;
use App\Repository\User1Repository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;

class ProfilController
    extends AbstractController
{

    /**
     * @Route("/profil", name="app_profil_index")
     */
    public function index(Security $security, User1Repository $user1Repository): Response
    {
        $user = $security->getUser();

        if ($user) {
            $nom = $user->getnom();
            $prenom = $user->getprenom();
            $option = $user->getoption();
            $promo = $user->getpromo();
            $email = $user->getemail();
            $id = $user->getid();
        }

    return $this->render('profil/index.html.twig', [
        'prenom' => $prenom,
        'email' => $email,
        'nom' => $nom,
        'promo' => $promo,
        'option' => $option,
        'id' => $id,
    ]);


    }


}