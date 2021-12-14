<?php

namespace App\Controller;

use App\Entity\Postcomment;
use App\Form\PostcommentType;
use App\Repository\PostcommentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PostcommentController extends AbstractController
{
    /**
     * @Route("/admin/postcomment", name="postcomment")
     */
    public function index(): Response
    {
        return $this->render('postcomment/index.html.twig', [
            'controller_name' => 'PostcommentController',
        ]);
    }
    /**
     * @param PostcommentRepository $repository
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route ("/admin/AffichePostC",name="AffichePostC")
     */
    public function AfficherPostcomment(PostcommentRepository $repository){
        //$repo=$this->getDoctrine()->getRepository(Classroom::class);
        $postcomment=$repository->findAll();
        return $this->render('postcomment/AfficherPostcomment.html.twig',
            ['postcomment'=>$postcomment]);
    }

    /**
     * @Route("/admin/Supppostc/{id}",name="kc")
     */

    function DeletePostcomment($id,PostcommentRepository $repository){
        $postcomment=$repository->find($id);
        $em=$this->getDoctrine()->getManager();
        $em->remove($postcomment);
        $em->flush();
        return $this->redirectToRoute('AffichePostC');
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/admin/AjoutePostC",name="AjoutePostC")
     */
    function AddPostcomment(Request $request){
        $postcomment=new Postcomment();
        $form=$this->createForm(PostcommentType::class,$postcomment);

        $form->add('Ajouter',SubmitType::class,[
            'attr'=>[
                'class'=>'btn btn-primary waves-effect waves-light']]);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $em=$this->getDoctrine()->getManager();
            $em->persist($postcomment);
            $em->flush();
            return $this->redirectToRoute('AffichePostC');

        }
        return $this->render('post_client/AddPostC.html.twig',
            [
                'CC'=>$form->createView()
            ]);
    }
    /**
     * @Route("/Updatepost/{id}",name="updatepostcomment")
     */
    function UpdatePostcomment(PostcommentRepository $repository,$id, Request $request){
        $postcomment=$repository->find($id);
        $form=$this->createForm(PostcommentType::class,$postcomment);
        $form->add('Update',SubmitType::class,[
            'attr'=>[
                'class'=>'btn btn-primary waves-effect waves-light']]);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em=$this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute("AffichePostC");

        }
        return $this->render('postcomment/UpdatepostC.html.twig',
            [
                'u'=>$form->createView()
            ]);

    }
}
