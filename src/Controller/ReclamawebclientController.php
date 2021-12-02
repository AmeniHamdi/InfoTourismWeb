<?php

namespace App\Controller;

use App\Entity\Reclamaweb;
use App\Form\ReclamawebclientType;
use App\Form\ReclamawebType;
use App\Repository\ReclamawebRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ReclamawebclientController extends AbstractController
{
    /**
     * @Route("/indexclient", name="indexclient")
     */
    public function index(): Response
    {
        return $this->render('reclamawebclient/index.html.twig', [
            'controller_name' => 'ReclamawebclientController',
        ]);
    }
    /**
     * @param  Request $request
     * @return  \Symfony\Component\HttpFoundation\Response
     * @Route("/AjouteReclamaClient",name="AjouteReclamaClient")
     */
    function Add(Request $request){
        $reclamaweb=new Reclamaweb();
        $form=$this->createForm(ReclamawebclientType::class,$reclamaweb);
        $form->add('Ajouter',SubmitType::class,[
            'attr'=>[
                'class'=>'btn btn-primary waves-effect waves-light']]);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $em=$this->getDoctrine()->getManager();
            $em->persist($reclamaweb);
            $em->flush();



            return $this->redirectToRoute('AjouteReclamaClient');

        }


        return $this->render('reclamawebclient/AddClient.html.twig',
            [
                'formC'=>$form->createView()
            ]);
    }

    /**
     * @param ReclamawebRepository $repository
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route ("/AfficheReclamaC",name="AfficheReclamaC")
     */
    public function AfficherReclama(ReclamawebRepository $repository){
        //$repo=$this->getDoctrine()->getRepository(Classroom::class);
        $reclamaweb=$repository->findAll();
        return $this->render('reclamaweb/AfficherReclamaC.html.twig',
            ['reclama'=>$reclamaweb]);
    }
    /**
     * @Route("/Supp/{id}",name="d")
     */

    function Delete($id,ReclamawebRepository $repository){
        $reclamaweb=$repository->find($id);
        $em=$this->getDoctrine()->getManager();
        $em->remove($reclamaweb);
        $em->flush();
        return $this->redirectToRoute('AfficheReclamaC');
    }
    /**
     * @Route("reclamawebc/Updatec/{id}",name="updatec")
     */
    function Update(ReclamawebRepository $repository,$id, Request $request){
        $classroom=$repository->find($id);
        $form=$this->createForm(ReclamawebclientType::class,$classroom);
        $form->add('Update',SubmitType::class,[
            'attr'=>[
                'class'=>'btn btn-primary waves-effect waves-light']]);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em=$this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute("AfficheReclamaC");

        }
        return $this->render('reclamaweb/Updatec.html.twig',
            [
                'fc'=>$form->createView()
            ]);

    }

}

