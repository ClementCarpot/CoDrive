<?php

namespace App\Controller;

use App\Entity\Annonce;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response; // Assurez-vous d'ajouter cette ligne
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ShowAnnonceController extends AbstractController
{
    /**
     * @Route("/annonce/{id}", name="show_annonce")
     */
    public function index(Annonce $annonce): Response
    {
        return $this->render('annonce/show.html.twig', [
            'annonce' => $annonce,
        ]);
    }
}
