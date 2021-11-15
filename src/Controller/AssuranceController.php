<?php

namespace App\Controller;

use App\Entity\Assurance;
use App\Form\AssuranceType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AssuranceController extends AbstractController
{
    /**
     * @Route("/assurance", name="assurance")
     */
    public function index(): Response
    {
        return $this->render('assurance/index.html.twig', [
            'controller_name' => 'AssuranceController',
        ]);
    }
    /**
     * @Route("/admin/assurance", name="assurance")
     */
    public function listeAssurances(): Response
    {
        $assurance = $this->getDoctrine()->getRepository(Assurance::class)->findAll();
        return $this->render('admin/listeAssurance.html.twig', ['assurance' => $assurance]);
    }

    /**
     * @Route("/admin/addAssurance", name="newAssurance")
     */
    public function addAssurance(Request $request)
    {
        $assurance = new Assurance();
        $form = $this->createForm(AssuranceType::class, $assurance);
        $form->handleRequest($request);
        dump($form);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($assurance);
            $em->flush();
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('assurance');
        }
        return $this->render("admin/addAssurance.html.twig", ["form" => $form->createView()]);
    }

    /**
     * @Route ("/admin/deleteAssurance/{id}",name="deleteAssurance")
     */
    public function deleteAssurance($id)
    {
        $assurance = $this->getDoctrine()->getRepository(Assurance::class)->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($assurance);
        $em->flush();
        return $this->redirectToRoute("assurance");
    }


    /**
     * @Route("/admin/updateAssurance/{id}",name="updateAssurance")
     */
    public function updateAssurance(Request $request, $id)
    {
        $assurance = $this->getDoctrine()->getRepository(Assurance::class)->find($id);
        $form = $this->createForm(AssuranceType::class, $assurance);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute("assurance");
        }
        return $this->render("admin/updateAssurance.html.twig", ["form" => $form->createView()]);
    }

}
