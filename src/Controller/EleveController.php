<?php

namespace App\Controller;

use App\Entity\Eleve;
use App\Entity\User1;
use App\Form\Eleve1Type;
use App\Repository\EleveRepository;
use http\Client\Curl\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/eleve")
 */
class EleveController extends AbstractController
{
    /**
     * @Route("/", name="app_eleve_index", methods={"GET"})
     */
    public function index(EleveRepository $eleveRepository): Response
    {
        $userId = $this->getUser()->getId();

        $users = $eleveRepository->findAll();
        $eleve = array();
        foreach ($users as $eleveItem) {
            if (in_array('ROLE_USER', $eleveItem->getRoles())) {
                $eleve[] = $eleveItem;
            }
        }

        return $this->render('eleve/index.html.twig', [
            'controller_name' => 'AccueilController',
            'eleves' => $eleve,
        ]);
    }

    /**
     * @Route("/new", name="app_eleve_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EleveRepository $eleveRepository): Response
    {
        $eleve = new User1();
        $form = $this->createForm(Eleve1Type::class, $eleve);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $eleveRepository->add($eleve, true);

            return $this->redirectToRoute('app_eleve_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('eleve/new.html.twig', [
            'eleve' => $eleve,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_eleve_show", methods={"GET"})
     */
    public function show(User1 $eleve): Response
    {
        return $this->render('eleve/show.html.twig', [
            'eleve' => $eleve,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_eleve_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, User1 $eleve, EleveRepository $eleveRepository): Response
    {
        $form = $this->createForm(Eleve1Type::class, $eleve);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $eleveRepository->add($eleve, true);

            return $this->redirectToRoute('app_eleve_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('eleve/edit.html.twig', [
            'eleve' => $eleve,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_eleve_delete", methods={"POST"})
     */
    public function delete(Request $request, User1 $eleve, EleveRepository $eleveRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$eleve->getId(), $request->request->get('_token'))) {
            $eleveRepository->remove($eleve, true);
        }

        return $this->redirectToRoute('app_eleve_index', [], Response::HTTP_SEE_OTHER);
    }
}
