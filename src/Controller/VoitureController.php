<?php

namespace App\Controller;

use App\Entity\Voiture;
use App\Form\VoitureType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class VoitureController extends AbstractController
{
    /**
     * @Route("/admin/voiture", name="voiture")
     */
    public function listeVoiture(): Response
    {
        $voiture = $this->getDoctrine()->getRepository(Voiture::class)->findAll();
        return $this->render('admin/listeVoiture.html.twig', ['voiture' => $voiture]);
    }

    /**
     * @Route("/admin/addVoiture", name="newVoiture")
     */
    public function addVoiture(Request $request)
    {
        $voiture = new Voiture();
        $form = $this->createForm(VoitureType::class, $voiture);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($voiture);
            $em->flush();
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('voiture');
        }
        return $this->render("admin/addVoiture.html.twig", array("form" => $form->createView()));
    }
    /**
     * @Route ("/admin/deleteVoiture/{id}",name="deleteVoiture")
     */
    public function deleteVoiture($id)
    {
        $voiture = $this->getDoctrine()->getRepository(Voiture::class)->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($voiture);
        $em->flush();
        return $this->redirectToRoute("voiture");
    }

    /**
     * @Route("/admin/updateVoiture/{id}",name="updateVoiture")
     */
    public function updateVoiture(Request $request, $id)
    {
        $voiture = $this->getDoctrine()->getRepository(Voiture::class)->find($id);
        $form = $this->createForm(VoitureType::class, $voiture);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute("voiture");
        }
        return $this->render("admin/updateVoiture.html.twig", ["form" => $form->createView()]);
    }
}
