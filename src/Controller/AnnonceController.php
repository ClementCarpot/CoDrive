<?php

namespace App\Controller;

use App\Entity\Annonce;
use App\Form\AnnonceType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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
            $entityManager->remove($annonce);
            $entityManager->flush();
        }

        return $this->redirectToRoute('edit_profil');
    }
}
