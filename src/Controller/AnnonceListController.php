<?php

namespace App\Controller;

use App\Entity\Annonce;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AnnonceListController extends AbstractController
{
    /**
     * @Route("/annonces", name="annonce_list")
     */
    public function index(): Response
    {
        $annonces = $this->getDoctrine()->getRepository(Annonce::class)->findAll();

        return $this->render('annonce/list.html.twig', [
            'annonces' => $annonces,
        ]);
    }
}
