<?php

namespace App\Controller;
use App\Entity\Transport;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TransportController extends AbstractController
{
    /**
     * @Route("/transport", name="transport")
     */
    public function index(): Response
    {
        return $this->render('transport/index.html.twig', [
            'controller_name' => 'TransportController',
        ]);
    }

    /**
     * @Route("/admin/transport", name="transport")
     */
    public function listeTransport(): Response
    {
        $transport = $this->getDoctrine()->getRepository(Transport::class)->findAll();
        return $this->render('admin/listeTransport.html.twig', ['transport' => $transport]);
    }
}
