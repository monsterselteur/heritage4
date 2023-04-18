<?php

namespace App\Controller;

use App\Entity\Situation;
use App\Form\SituationType;
use App\Repository\SituationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/situation")
 */
class SituationController extends AbstractController
{
    /**
     * @Route("/", name="app_situation_index", methods={"GET"})
     */
    public function index(SituationRepository $situationRepository): Response
    {
        return $this->render('situation/index.html.twig', [
            'situations' => $situationRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_situation_new", methods={"GET", "POST"})
     */
    public function new(Request $request, SituationRepository $situationRepository): Response
    {
        $situation = new Situation();
        $form = $this->createForm(SituationType::class, $situation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $situationRepository->add($situation, true);

            return $this->redirectToRoute('app_situation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('situation/new.html.twig', [
            'situation' => $situation,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_situation_show", methods={"GET"})
     */
    public function show(Situation $situation): Response
    {
        return $this->render('situation/show.html.twig', [
            'situation' => $situation,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_situation_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Situation $situation, SituationRepository $situationRepository): Response
    {
        $form = $this->createForm(SituationType::class, $situation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $situationRepository->add($situation, true);

            return $this->redirectToRoute('app_situation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('situation/edit.html.twig', [
            'situation' => $situation,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_situation_delete", methods={"POST"})
     */
    public function delete(Request $request, Situation $situation, SituationRepository $situationRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$situation->getId(), $request->request->get('_token'))) {
            $situationRepository->remove($situation, true);
        }

        return $this->redirectToRoute('app_situation_index', [], Response::HTTP_SEE_OTHER);
    }
}
