<?php

namespace App\Controller;

use App\Entity\Activite;
use App\Form\ActiviteType;
use App\Repository\ActiviteRepository;
use App\Repository\TypeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class ActiviteController extends AbstractController
{
    /**
     * @Route("/activite", name="activite")
     */
    public function index(): Response
    {
        return $this->render('activite/index.html.twig', [
            'controller_name' => 'ActiviteController',
        ]);
    }

    /**
     * @param ActiviteRepository $repository
     * @return Response
     * @Route("/AfficheActivite",name="AfficheActivite")
     */
    public function Affiche(ActiviteRepository $repository)
    {
        //$repo=$this->getDoctrine()->getRepository(activite::class);
        $activite = $repository->findAll();
        return $this->render('activites/Affichageclien.html.twig', ['activite' => $activite]);
    }

    /**
     * @param ActiviteRepository $repository
     * @return Response
     * @Route("/AfficheActiviteadmin",name="AfficheActiviteadmin")
     */
    public function AfficheAdmin(ActiviteRepository $repository)
    {
        //$repo=$this->getDoctrine()->getRepository(activite::class);
        $activite = $repository->findAll();
        return $this->render('activites/Affichageadmin.html.twig', ['activite' => $activite]);
    }
    /**
     * @Route("delete/{id}",name="t")
     */
    function delete($id, ActiviteRepository $repository)
    {
        $activite = $repository->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($activite);
        $em->flush();
        return $this->redirectToRoute('AfficheActivite');
    }

    /**
     * @Route("/addactivite",name="addactivite")
     */
    function Add(Request $request)
    {
        $activite = new Activite();
        $form = $this->createForm(ActiviteType::class, $activite);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($activite);
            $em->flush();
        }
        return $this->render('activites/Add.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @route("activite/Update/{id}",name="Update")
     */
    function update(ActiviteRepository $repository, $id,Request $request)
    {
        $activite = $repository->find($id);
        $form = $this->createForm(ActiviteType::class, $activite);
        $form->add('Update', SubmitType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute("AfficheActivite");
        }
        return $this->render('activites/Update.html.twig',
        [
            'f' => $form->createView()
        ]);
    }

}
