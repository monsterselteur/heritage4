<?php

namespace App\Controller;

use App\Entity\User1;
use App\Form\ProfType;
use App\Repository\ProfRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @IsGranted
 * @Route("/prof")
 */
class ProfController extends AbstractController
{
    /**
     * @Route("/", name="app_prof_index", methods={"GET"})
     */
    public function index(ProfRepository $profRepository): Response
    {
        return $this->render('prof/index.html.twig', [
            'profs' => $profRepository->findAll(),
        ]);
    }

    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/new", name="app_prof_new", methods={"GET", "POST"})
     */
    public function new(Request $request, ProfRepository $profRepository): Response
    {
        $prof = new User1();
        $form = $this->createForm(ProfType::class, $prof);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $profRepository->add($prof, true);

            return $this->redirectToRoute('app_prof_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('prof/new.html.twig', [
            'prof' => $prof,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_prof_show", methods={"GET"})
     */
    public function show(User1 $prof): Response
    {
        return $this->render('prof/show.html.twig', [
            'prof' => $prof,
        ]);
    }

    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/{id}/edit", name="app_prof_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, User1 $prof, ProfRepository $profRepository): Response
    {
        $form = $this->createForm(ProfType::class, $prof);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $profRepository->add($prof, true);

            return $this->redirectToRoute('app_prof_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('prof/edit.html.twig', [
            'prof' => $prof,
            'form' => $form,
        ]);
    }

    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/{id}", name="app_prof_delete", methods={"POST"})
     */
    public function delete(Request $request, User1 $prof, ProfRepository $profRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$prof->getId(), $request->request->get('_token'))) {
            $profRepository->remove($prof, true);
        }

        return $this->redirectToRoute('app_prof_index', [], Response::HTTP_SEE_OTHER);
    }
}
