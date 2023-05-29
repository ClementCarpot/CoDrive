<?php

namespace App\Repository;

use App\Entity\Annonce;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class AnnonceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Annonce::class);
    }

    public function rechercherAnnonces($departure, $arrival, $date, $hour)
    {
        $qb = $this->createQueryBuilder('a');

        if ($departure) {
            $qb->andWhere('a.villeDepart = :departure')
                ->setParameter('departure', $departure);
        }

        if ($arrival) {
            $qb->andWhere('a.villeArrive = :arrival')
                ->setParameter('arrival', $arrival);
        }

        if ($date) {
            $qb->andWhere('a.dateDepart = :date')
                ->setParameter('date', new \DateTime($date));
        }

        if ($hour) {
            $qb->andWhere('a.heureDepart = :hour')
                ->setParameter('hour', \DateTime::createFromFormat('H:i', $hour));
        }

        return $qb->getQuery()->getResult();
    }
}
