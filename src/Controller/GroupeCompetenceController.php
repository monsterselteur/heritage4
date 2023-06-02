<?php

namespace App\Controller;

use App\Entity\GroupeCompetence;
use App\Form\GroupeCompetenceType;
use App\Repository\GroupeCompetenceRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @IsGranted
 * @Route("/groupe/competence")
 */
class GroupeCompetenceController extends AbstractController
{
    /**
     * @Route("/", name="app_groupe_competence_index", methods={"GET"})
     */
    public function index(GroupeCompetenceRepository $groupeCompetenceRepository): Response
    {
        return $this->render('groupe_competence/index.html.twig', [
            'groupe_competences' => $groupeCompetenceRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_groupe_competence_new", methods={"GET", "POST"})
     */
    public function new(Request $request, GroupeCompetenceRepository $groupeCompetenceRepository): Response
    {
        $groupeCompetence = new GroupeCompetence();
        $form = $this->createForm(GroupeCompetenceType::class, $groupeCompetence);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $groupeCompetenceRepository->add($groupeCompetence, true);

            return $this->redirectToRoute('app_groupe_competence_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('groupe_competence/new.html.twig', [
            'groupe_competence' => $groupeCompetence,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_groupe_competence_show", methods={"GET"})
     */
    public function show(GroupeCompetence $groupeCompetence): Response
    {
        return $this->render('groupe_competence/show.html.twig', [
            'groupe_competence' => $groupeCompetence,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_groupe_competence_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, GroupeCompetence $groupeCompetence, GroupeCompetenceRepository $groupeCompetenceRepository): Response
    {
        $form = $this->createForm(GroupeCompetenceType::class, $groupeCompetence);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $groupeCompetenceRepository->add($groupeCompetence, true);

            return $this->redirectToRoute('app_groupe_competence_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('groupe_competence/edit.html.twig', [
            'groupe_competence' => $groupeCompetence,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_groupe_competence_delete", methods={"POST"})
     */
    public function delete(Request $request, GroupeCompetence $groupeCompetence, GroupeCompetenceRepository $groupeCompetenceRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$groupeCompetence->getId(), $request->request->get('_token'))) {
            $groupeCompetenceRepository->remove($groupeCompetence, true);
        }

        return $this->redirectToRoute('app_groupe_competence_index', [], Response::HTTP_SEE_OTHER);
    }
}
