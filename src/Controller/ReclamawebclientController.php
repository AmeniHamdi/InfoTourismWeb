<?php

namespace App\Controller;

use App\Entity\Reclamaweb;
use App\Form\ReclamawebclientType;
use App\Form\ReclamawebType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ReclamawebclientController extends AbstractController
{
    /**
     * @Route("/index", name="index")
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
                'form'=>$form->createView()
            ]);
    }
}

