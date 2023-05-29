<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Form\ProfileFormType;
use App\Repository\AnnonceRepository;
use App\Repository\ReservationRepository;
use App\Repository\UtilisateurRepository;


class ProfileController extends AbstractController
{
    /**
     * @Route("/profile", name="user_profile")
     */
    public function index(UserInterface $user): Response
    {
        return $this->render('profile/index.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/profil/edit", name="profil_edit")
     */
    public function editProfile(Request $request, UserPasswordEncoderInterface $passwordEncoder, AnnonceRepository $annonceRepository, ReservationRepository $reservationRepository, UtilisateurRepository $utilisateurRepository): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(ProfileFormType::class, $user);
        $annonces = $annonceRepository->findBy(['conducteur' => $user]);
        $reservations = $reservationRepository->findBy(['passager' => $user]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();

            $this->addFlash('success', 'Votre profil a été mis à jour.');

            return $this->redirectToRoute('accueil');
        }

        return $this->render('profile/edit.html.twig', [
            'form' => $form->createView(),
            'annonces' => $annonces,
            'user' => $user,
            'reservations' => $reservations,
        ]);
    }


    /**
     * @Route("/change-locale/{locale}", name="change_locale")
     */
    public function changeLocale($locale, Request $request)
    {
        $request->getSession()->set('_locale', $locale);

        return $this->redirect($request->headers->get('referer'));
    }
}
