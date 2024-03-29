<?php

namespace App\Controller;

use App\Entity\Annonce;
use App\Entity\Commentaire;
use App\Form\AnnonceType;
use App\Form\CommentaireType;
use App\Repository\AnnonceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\PropertyAccess\PropertyAccessor;


class AnnonceController extends AbstractController
{
    /**
     * @Route("/annonce/new", name="annonce_new")
     */
    public function createAnnonce(Request $request): Response
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

            return $this->redirectToRoute('mes_annonces');
        }

        return $this->render('annonce/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/annonce/delete/{id}", name="annonce_delete")
     */
    public function delete(Request $request, Annonce $annonce): Response
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

    /**
     * @Route("/annonce/{id}", name="annonce_show")
     */
    public function show(Request $request, Annonce $annonce): Response
    {
        $commentaire = new Commentaire();
        $form = $this->createForm(CommentaireType::class, $commentaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $commentaire->setAuteur($this->getUser());
            $commentaire->setAnnonce($annonce);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($commentaire);
            $entityManager->flush();

            return $this->redirectToRoute('annonce_show', ['id' => $annonce->getId()]);
        }

        return $this->render('annonce/show.html.twig', [
            'annonce' => $annonce,
            'form' => $form->createView(),
        ]);
    }

    // TA FONCTIONS AJOUT COMMENTAIRE A AJOUTER ICI

    // ----------- MA SUPER FONCTION D'AJOUT DE COMMENTAIRE --------

    ////////////////////////////////


    /**
     * @Route("/annonces", name="annonces")
     */
    public function annonces(Request $request, AnnonceRepository $annonceRepository): Response
    {
        $departure = $request->query->get('departure');
        $arrival = $request->query->get('arrival');
        $date = $request->query->get('date');
        $hour = $request->query->get('hour');

        // Construction de votre requête personnalisée en fonction des paramètres de filtrage
        $queryBuilder = $annonceRepository->createQueryBuilder('a');

        if ($departure) {
            $queryBuilder->andWhere('a.villeDepart = :departure')->setParameter('departure', $departure);
        }

        if ($arrival) {
            $queryBuilder->andWhere('a.villeArrive = :arrival')->setParameter('arrival', $arrival);
        }

        if ($date) {
            // Convertir la chaîne de date en objet DateTime pour pouvoir comparer les dates
            $date = new \DateTime($date);
            $queryBuilder->andWhere('a.dateDepart = :date')->setParameter('date', $date);
        }

        if ($hour) {
            // Convertir la chaîne d'heure en objet DateTime pour pouvoir comparer les heures
            $hour = new \DateTime($hour);
            $queryBuilder->andWhere('a.heureDepart = :hour')->setParameter('hour', $hour);
        }

        // Exécution de la requête et récupération des annonces filtrées
        $annonces = $queryBuilder->getQuery()->getResult();

        return $this->render('annonce/annonces.html.twig', [
            'annonces' => $annonces,
        ]);
    }
    /**
     * @Route("/annonce/{id}", name="edit_announcement")
     */
    /**
     * @Route("/annonce/{id}/edit", name="annonce_edit")
     */
    public function editAnnonce(Request $request, Annonce $annonce): Response
    {
        $form = $this->createForm(AnnonceType::class, $annonce);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();

            return $this->redirectToRoute('mes_annonces');
        }

        return $this->render('annonce/edit.html.twig', [
            'form' => $form->createView(),
            'annonce' => $annonce,
        ]);
    }

    // /**
    //  * @Route("/annonce/{id}/duplicate", name="annonce_duplicate")
    //  */
    // public function duplicate(Request $request, Annonce $annonce): Response
    // {
    //     // Create a new instance of the Annonce entity
    //     $newAnnonce = new Annonce();

    //     // Copy the properties from the existing announcement to the new one
    //     $propertyAccessor = PropertyAccess::createPropertyAccessor();
    //     $propertyAccessor->setValue($newAnnonce, 'conducteur', $annonce->getConducteur());
    //     // Copy other properties as needed

    //     $form = $this->createForm(AnnonceType::class, $newAnnonce);
    //     $form->handleRequest($request);

    //     if ($form->isSubmitted() && $form->isValid()) {
    //         $entityManager = $this->getDoctrine()->getManager();
    //         $entityManager->persist($newAnnonce);
    //         $entityManager->flush();

    //         return $this->redirectToRoute('mes_annonces');
    //     }

    //     return $this->render('annonce/duplicate.html.twig', [
    //         'form' => $form->createView(),
    //         'annonce' => $newAnnonce,
    //     ]);
    // }

    public function duplicate(Annonce $trajet, Request $request, EntityManagerInterface $entityManager): Response
    {
        $nouveauTrajet = clone $trajet;
        $form = $this->createForm(AnnonceType::class, $nouveauTrajet);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $nouveauTrajet->setConducteur($this->getUser());
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($nouveauTrajet);
            $entityManager->flush();
            $this->addFlash('success', 'Trajet dupliqué avec succès');
            return $this->redirectToRoute('mes_annonces');
        }
        return $this->render('annonce/duplicate.html.twig', ['nouveauTrajet' => $nouveauTrajet, 'form' => $form->createView()]);
    }
    /**
     * @Route("/annonce/{id}/update", name="annonce_update", methods={"POST"})
     */
    public function updateAnnonce(Request $request, Annonce $annonce): Response
    {
        // Handle the form submission and update the "annonce" entity
        $form = $this->createForm(AnnonceType::class, $annonce);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();

            return $this->redirectToRoute('mes_annonces');
        }

        return $this->render('annonce/edit.html.twig', [
            'form' => $form->createView(),
            'annonce' => $annonce,
        ]);
    }
}
