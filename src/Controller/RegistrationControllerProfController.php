<?php

namespace App\Controller;


use App\Entity\Prof;
use App\Entity\User1;
use App\Entity\UserProf;
use App\Form\ProfType;
use App\Form\User1Type;
use App\Form\UserProfType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegistrationControllerProfController extends AbstractController
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * @Route("/registration/prof", name="registration1")
     */
    public function index(Request $request)
    {
        $user = new User1();

        $form = $this->createForm(User1Type::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Encode the new users password
            $user->setPassword($this->passwordEncoder->encodePassword($user, $user->getPassword()));

            // Set their role
            $user->setRoles(['ROLE_USER','ROLE_PROF']);

            // Save
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('app_login');
        }

        return $this->render('registration_controller_prof/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
