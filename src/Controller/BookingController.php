<?php

namespace App\Controller;

use App\Entity\Annonce;
use App\Entity\Reservation;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Doctrine\ORM\EntityManagerInterface;


class BookingController extends AbstractController
{
    /**
     * @IsGranted("ROLE_USER")
     * @Route("/booking/reserve/{id}", name="booking_reserve")
     */
    public function reserve(Annonce $annonce): Response
    {
        // Créer un nouveau booking
        $booking = new Reservation();
        $booking->setAnnonce($annonce);

        // Définir l'utilisateur qui fait la réservation comme passager
        $user = $this->getUser();
        if ($user) {
            $booking->setPassager($user);
        } else {
            // Rediriger l'utilisateur vers la page de connexion s'il n'est pas connecté
            return $this->redirectToRoute('app_login');
        }

        $em = $this->getDoctrine()->getManager();
        $em->persist($booking);
        $em->flush();

        // Redirige vers la page de l'annonce ou une autre page, peut-être avec un message flash de succès
        return $this->redirectToRoute('mes_reservations');
    }

    /**
     * @IsGranted("ROLE_USER")
     * @Route("/mes_reservations", name="reservations_index")
     */
    public function index(): Response
    {
        $user = $this->getUser();
        if ($user) {
            $reservations = $user->getReservations();
        } else {
            // Si l'utilisateur n'est pas connecté, redirigez-le vers la page de connexion
            return $this->redirectToRoute('app_login');
        }

        return $this->render('reservations/index.html.twig', [
            'reservations' => $reservations,
        ]);
    }

    /**
     * @Route("/reservation/cancel/{id}", name="cancel_reservation", methods={"POST"})
     */
    public function cancel(int $id, EntityManagerInterface $em): Response
    {
        $reservation = $em->getRepository(Reservation::class)->find($id);

        if (!$reservation) {
            throw $this->createNotFoundException('No reservation found for id ' . $id);
        }

        $em->remove($reservation);
        $em->flush();

        $this->addFlash('success', 'Réservation annulée avec succès.');

        return $this->redirectToRoute('mes_reservations');
    }
    /**
     * @Route("/reservation/{id}", name="reservation_show")
     */
    public function show(Request $request, Reservation $reservation)
    {
        $commentaire = new Commentaire();
        $form = $this->createForm(CommentaireType::class, $commentaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $commentaire->setAuteur($this->getUser());
            $commentaire->setAnnonce($reservation->getAnnonce());
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($commentaire);
            $entityManager->flush();

            return $this->redirectToRoute('reservation_show', ['id' => $reservation->getId()]);
        }

        return $this->render('reservation/show.html.twig', [
            'reservation' => $reservation,
            'form' => $form->createView(),
        ]);
    }
}
