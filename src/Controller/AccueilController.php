<?php

namespace App\Controller;

use App\Repository\CompetenceRepository;
use App\Repository\EleveRepository;
use App\Repository\SituationRepository;
use App\Repository\User1Repository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccueilController extends AbstractController
{
    /**
     * @Route("/accueil", name="app_accueil")
     */
    public function index(EleveRepository $eleveRepository, SituationRepository $situationRepository): Response
    {
        $situations = $situationRepository->findAll();
        $users = $eleveRepository->findAll();
        $eleve = array();
        foreach ($users as $eleveItem) {
            if (in_array('ROLE_USER', $eleveItem->getRoles())) {
                $eleve[] = $eleveItem;
            }
        }

        $pasadmin = array();
        foreach ($users as $eleveItem) {
            if (in_array('ROLE_USER', $eleveItem->getRoles())) {
                $pasadmin[] = $eleveItem;
            }
            if (in_array('ROLE_PROF', $eleveItem->getRoles())) {
                $pasadmin[] = $eleveItem;
            }

        }

        return $this->render('accueil/index.html.twig', [
            'controller_name' => 'AccueilController',
            'eleves' => $eleve,
            'users' => $pasadmin,
            'situation' => $situations
        ]);
    }
}
