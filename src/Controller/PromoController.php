<?php

namespace App\Controller;

use App\Entity\Promo;
use App\Entity\User1;
use App\Form\DeleteUsersType;
use App\Form\PromoType;
use App\Repository\EleveRepository;
use App\Repository\PromoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/promo")
 */
class PromoController extends AbstractController
{
    /**
     * @Route("/", name="app_promo_index", methods={"GET"})
     */
    public function index(PromoRepository $promoRepository): Response
    {
        return $this->render('promo/index.html.twig', [
            'promos' => $promoRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_promo_new", methods={"GET", "POST"})
     */
    public function new(Request $request, PromoRepository $promoRepository): Response
    {
        $promo = new Promo();
        $form = $this->createForm(PromoType::class, $promo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $promoRepository->add($promo, true);

            return $this->redirectToRoute('app_promo_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('promo/new.html.twig', [
            'promo' => $promo,
            'form' => $form,
        ]);
    }


    /**
     * @Route("/{id}", name="app_promo_show", methods={"GET"})
     */
    public function show(Promo $promo): Response
    {
        return $this->render('promo/show.html.twig', [
            'promo' => $promo,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_promo_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Promo $promo, PromoRepository $promoRepository): Response
    {
        $form = $this->createForm(PromoType::class, $promo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $promoRepository->add($promo, true);

            return $this->redirectToRoute('app_promo_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('promo/edit.html.twig', [
            'promo' => $promo,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_promo_delete", methods={"POST"})
     */
    public function delete(Request $request, Promo $promo, PromoRepository $promoRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$promo->getId(), $request->request->get('_token'))) {
            $promoRepository->remove($promo, true);
        }

        return $this->redirectToRoute('app_promo_index', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/{id}/add-user", name="app_promo_addusertopromo", methods={"GET", "POST"})
     */
    public function addUserToPromo(EleveRepository $eleveRepository, Request $request, $id): Response
    {
        $promo = $this->getDoctrine()
            ->getRepository(Promo::class)
            ->find($id);

        if ($request->isMethod('POST')) {
            $userId = $request->request->get('user');
            $user = $eleveRepository->find($userId);
            $promo->addEleve($user);
            $this->getDoctrine()->getManager()->flush();
        }
        $users = $eleveRepository->findAll();
        $eleve = array();
        foreach ($users as $eleveItem) {
            if (in_array('ROLE_USER', $eleveItem->getRoles())and $eleveItem->getPromo() != null) {
                if ($eleveItem->getPromo()->getId() != $id) {
                    $eleve[] = $eleveItem;
                }
            }
            elseif (in_array('ROLE_USER', $eleveItem->getRoles())){
                $eleve[] = $eleveItem;
            }
        }

        return $this->render('promo/add_user.html.twig', [
            'promo' => $promo,
            'eleve'=> $eleve
        ]);
    }
    /**
     * @Route("/{id}/supp-user", name="app_promo_suppusertopromo", methods={"GET", "POST"})
     */
    public function suppUserToPromo(EleveRepository $eleveRepository, Request $request, $id): Response
    {
        $promo = $this->getDoctrine()
            ->getRepository(Promo::class)
            ->find($id);

        if ($request->isMethod('POST')) {
            $userId = $request->request->get('user');
            if ($userId) {
                $user = $eleveRepository->find($userId);
                $promo->removeUser1($user);
                $this->getDoctrine()->getManager()->flush();
            }
        }

        $users = $eleveRepository->findAll();
        $eleve = array();
        foreach ($users as $eleveItem) {
            if ($eleveItem->getPromo() != null) {
                if ($eleveItem->getPromo()->getId() == $id) {
                    $eleve[] = $eleveItem;
                }
            }
        }

        return $this->render('promo/supp_user.html.twig', [
            'promo' => $promo,
            'eleve'=> $eleve
        ]);
    }

}