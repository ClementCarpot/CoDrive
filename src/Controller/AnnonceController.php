<?php

namespace App\Controller;

use App\Entity\Annonce;
use App\Form\AnnonceType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\AnnonceRepository;


class AnnonceController extends AbstractController
{
    public function createAnnonce(Request $request)
    {
        $annonce = new Annonce();

        // récupérer l'utilisateur actuellement connecté
        $nom = $this->getUser();
        $annonce->setConducteur($nom);

        $form = $this->createForm(AnnonceType::class, $annonce);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($annonce);
            $entityManager->flush();

            return $this->redirectToRoute('edit_profil');
        }

        return $this->render('annonce/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/annonce/delete/{id}", name="annonce_delete")
     */
    public function delete(Request $request, Annonce $annonce)
    {
        if ($this->isCsrfTokenValid('delete' . $annonce->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();

            // Avant de supprimer l'annonce, supprimez toutes les réservations associées
            foreach ($annonce->getReservations() as $reservation) {
                $entityManager->remove($reservation);
            }

            $entityManager->remove($annonce);
            $entityManager->flush();
        }

        return $this->redirectToRoute('edit_profil');
    }


    /**
     * @Route("/mes_annonces", name="mes_annonces")
     */
    public function mesAnnonces(AnnonceRepository $annonceRepository): Response
    {

        $user = $this->getUser();

        $annonces = $annonceRepository->findBy(['conducteur' => $user]);

        return $this->render('annonce/mes_annonces.html.twig', [
            'annonces' => $annonces,
        ]);
    }
}
