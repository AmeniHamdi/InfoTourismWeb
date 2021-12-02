<?php

namespace App\Controller;

use App\Entity\Reclamaweb;
use App\Form\ReclamawebType;
use App\Repository\ReclamawebRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Services\MailerService;



class ReclamawebController extends AbstractController
{
    /**
     * @Route("/index", name="index")
     */
    public function index(): Response
    {
        return $this->render('reclamaweb/index.html.twig', [
            'controller_name' => 'ReclamawebController',
        ]);
    }
    /**
     * @Route("/blog", name="blog")
     */
    public function blog(): Response
    {
        return $this->render('reclamaweb/blog.html.twig', [
            'controller_name' => 'ReclamawebController',
        ]);
    }
    /**
     * @param ReclamawebRepository $repository
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route ("/AfficheReclama",name="AfficheReclama")
     */
    public function AfficherReclama(ReclamawebRepository $repository){
        //$repo=$this->getDoctrine()->getRepository(Classroom::class);
        $reclamaweb=$repository->findAll();
        return $this->render('reclamaweb/AfficherReclama.html.twig',
            ['reclama'=>$reclamaweb]);
    }
    /**
     * @Route("/profile", name="profile")
     */
    public function profile(): Response
    {
        return $this->render('reclamaweb/profile.html.twig', [
            'controller_name' => 'ReclamawebController',
        ]);
    }
    /**
     * @Route("/DetailReclama", name="DetailReclama")
     */
    public function DetailReclama(ReclamawebRepository $repository): Response
    {
        $reclamaweb=$repository->findAll();
        return $this->render('reclamaweb/DetailReclama.html.twig',
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
        return $this->redirectToRoute('DetailReclama');
    }
    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/AjouteReclama",name="AjouteReclama")
     *
     */
    function Add(Request $request ){
        $reclamaweb=new Reclamaweb();
        $form=$this->createForm(ReclamawebType::class,$reclamaweb);
        $form->add('Ajouter',SubmitType::class,[
            'attr'=>[
                'class'=>'btn btn-primary waves-effect waves-light']]);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $em=$this->getDoctrine()->getManager();
            $em->persist($reclamaweb);
            $em->flush();


            return $this->redirectToRoute('AfficheReclama');

        }


        return $this->render('reclamaweb/Add.html.twig',
            [
            'form'=>$form->createView()
        ]);
    }
    /**
     * @Route("reclamaweb/Update/{id}",name="update")
     */
    function Update(ReclamawebRepository $repository,$id, Request $request){
        $classroom=$repository->find($id);
        $form=$this->createForm(ReclamawebType::class,$classroom);
        $form->add('Update',SubmitType::class,[
        'attr'=>[
            'class'=>'btn btn-primary waves-effect waves-light']]);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em=$this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute("AfficheReclama");

        }
        return $this->render('reclamaweb/Update.html.twig',
            [
                'f'=>$form->createView()
            ]);

}

}
