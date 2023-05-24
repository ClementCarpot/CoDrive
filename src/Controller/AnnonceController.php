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
        $user = $this->getUser();
        $annonce->setConducteur($user);

        $form = $this->createForm(AnnonceType::class, $annonce);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($annonce);
            $entityManager->flush();

            return $this->redirectToRoute('annonce_show', ['id' => $annonce->getId()]);
        }

        return $this->render('annonce/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
