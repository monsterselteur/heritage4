<?php

namespace App\Controller;

use App\Repository\EleveRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccueilController extends AbstractController
{
    /**
     * @Route("/accueil", name="app_accueil")
     */
    public function index(EleveRepository $eleveRepository): Response
    {
        $eleves = $eleveRepository->findAll();
        $eleve = array();
        foreach ($eleves as $eleveItem) {
            if (in_array('ROLE_USER', $eleveItem->getRoles())) {
                $eleve[] = $eleveItem;
            }
        }

        return $this->render('accueil/index.html.twig', [
            'controller_name' => 'AccueilController',
            'eleves' => $eleve

        ]);
    }
}
