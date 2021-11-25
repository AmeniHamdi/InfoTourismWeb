<?php

namespace App\Controller;

use App\Entity\Voiture;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ClientController extends AbstractController
{
    /**
     * @Route("/client", name="client")
     */
    public function index(): Response
    {
        return $this->render('client/indexClient.html.twig', [
            'controller_name' => 'ClientController',
        ]);
    }

    /**
     * @Route("/client/voiture", name="locationvoiture")
     */
    public function listelocationVoiture(): Response
    {
        $voiture = $this->getDoctrine()->getRepository(Voiture::class)->findAll();
        return $this->render('client/locationVoiture.html.twig', ['voiture' => $voiture]);
    }



}
