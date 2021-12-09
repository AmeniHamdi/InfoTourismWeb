<?php

namespace App\Controller;

use App\Entity\Transport;
use App\Form\TransportType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TransportController extends AbstractController
{
    /**
     * @Route("/admin/transport", name="transport")
     */
    public function listeTransport(): Response
    {
        $transport = $this->getDoctrine()->getRepository(Transport::class)->findAll();
        return $this->render('admin/listeTransport.html.twig', ['transport' => $transport]);
    }

    /**
     * @Route("/admin/addTransport", name="newTransport")
     */
    public function addTransport(Request $request)
    {
        $transport = new Transport();
        $form = $this->createForm(TransportType::class, $transport);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($transport);
            $em->flush();
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('transport');
        }
        return $this->render("admin/addTransport.html.twig", array("form" => $form->createView()));
    }

    /**
     * @Route ("/admin/deleteTransport/{id}",name="deleteTransport")
     */
    public function deleteTransport($id)
    {
        $transport = $this->getDoctrine()->getRepository(Transport::class)->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($transport);
        $em->flush();
        return $this->redirectToRoute("transport");
    }


    /**
     * @Route("/admin/updateTransport/{id}",name="updateTransport")
     */
    public function updateTransport(Request $request, $id)
    {
        $transport = $this->getDoctrine()->getRepository(Transport::class)->find($id);
        $form = $this->createForm(TransportType::class, $transport);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute("transport");
        }
        return $this->render("admin/updateTransport.html.twig", ["form" => $form->createView()]);
    }
}
