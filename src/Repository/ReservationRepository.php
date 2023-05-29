<?php

namespace App\Repository;

use App\Entity\Reservation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class ReservationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Reservation::class);
    }

    // Exemple de méthode pour récupérer toutes les réservations d'un utilisateur
    public function findReservationsByUser($user)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.passager = :user')
            ->setParameter('user', $user)
            ->getQuery()
            ->getResult();
    }

    // Exemple de méthode pour récupérer toutes les réservations associées à une annonce
    public function findReservationsByAnnonce($annonce)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.annonce = :annonce')
            ->setParameter('annonce', $annonce)
            ->getQuery()
            ->getResult();
    }

    // Exemple de méthode pour calculer le nombre total de réservations
    public function countTotalReservations()
    {
        return $this->createQueryBuilder('r')
            ->select('COUNT(r.id)')
            ->getQuery()
            ->getSingleScalarResult();
    }

    // Ajoutez d'autres méthodes spécifiques en fonction de vos besoins
}
