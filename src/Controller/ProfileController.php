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
    public function editProfile(Request $request, UserPasswordEncoderInterface $passwordEncoder, AnnonceRepository $annonceRepository): Response
    {
        $user = $this->getUser(); // Obtenez l'utilisateur actuellement connecté
        $form = $this->createForm(ProfileFormType::class, $user);
        $annonces = $annonceRepository->findBy(['conducteur' => $user]); // ajoutez cette ligne

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Enregistrez les modifications dans la base de données
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();

            $this->addFlash('success', 'Votre profil a été mis à jour.');

            return $this->redirectToRoute('accueil');
        }

        return $this->render('profile/edit.html.twig', [
            'form' => $form->createView(),
            'annonces' => $annonces, // ajoutez cette ligne
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
