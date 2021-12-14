<?php

namespace App\Controller;

use App\Entity\Post;
use App\Entity\Postcomment;
use App\Entity\Views;
use App\Entity\Vue;
use App\Form\PostType;
use App\Form\VueType;
use App\Repository\PostRepository;
use App\Repository\ViewsRepository;
use App\Repository\VueRepository;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

class PostController extends AbstractController
{
    /**
     * @Route("/post", name="post")
     */
    public function index(): Response
    {
        return $this->render('post/index.html.twig', [
            'controller_name' => 'PostController',
        ]);
    }

    /**
     * @param PostRepository $repository
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route ("/AffichePost",name="AffichePost")
     */
    public function AfficherPost(PostRepository $repository){
        //$repo=$this->getDoctrine()->getRepository(Classroom::class);
        $post=$repository->findAllPosts();
        return $this->render('post/AfficherPost.html.twig',
            ['post'=>$post]);
    }


    /**
     * @Route("/Supppost/{id}",name="k")
     */

    function DeletePost($id,PostRepository $repository){
        $post=$repository->find($id);
        $em=$this->getDoctrine()->getManager();
        $em->remove($post);
        $em->flush();
        return $this->redirectToRoute('AffichePost');
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/AjoutePost",name="AjoutePost")
     */
    function AddPost(Request $request){
        $post=new Post();
        $form=$this->createForm(PostType::class,$post);
        $form->add('Ajouter',SubmitType::class,[
            'attr'=>[
                'class'=>'btn btn-primary waves-effect waves-light']]);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $em=$this->getDoctrine()->getManager();
            $file=$post->getPhoto();
            $filename= md5(uniqid()) . '.' . $file->guessExtension();
            $file->move($this->getParameter('photos_directory'),$filename);
            $post->setPhoto($filename);


            $em->persist($post);
            $em->flush();



            return $this->redirectToRoute('AffichePost');

        }


        return $this->render('post/AddPost.html.twig',
            [
                'form'=>$form->createView()
            ]);
    }
    /**
     * @Route("/Update/{id}",name="updatepost")
     */
    function UpdatePost(PostRepository $repository,$id, Request $request){
        $post=$repository->find($id);
        $form=$this->createForm(PostType::class,$post);
        $form->add('Update',SubmitType::class,[
            'attr'=>[
                'class'=>'btn btn-primary waves-effect waves-light']]);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em=$this->getDoctrine()->getManager();
            $file=$post->getPhoto();
            $filename= md5(uniqid()) . '.' . $file->guessExtension();
            $file->move($this->getParameter('photos_directory'),$filename);
            $post->setPhoto($filename);
            $em->persist($post);
            $em->flush();
            return $this->redirectToRoute("AffichePost");

        }
        return $this->render('post/Updatepost.html.twig',
            [
                't'=>$form->createView()
            ]);

    }
    /**
     * @Route("/DetailPost/{id}",name="DetailPost")
     */
    function showdetailedAction($id,PostRepository $repository){
        $em=$this->getDoctrine()->getManager();
        $post=$repository->find($id);
        $form=$this->createForm(PostType::class,$post);
        $nbr= $post->getViews();
        //var_dump($nbr).die();
        $post->setViews($nbr+1);
        $form->add('Detail',SubmitType::class,[
            'attr'=>[
                'class'=>'btn btn-primary waves-effect waves-light']]);

        return $this->render('post/detailpost.html.twig',
        [
            'title'=>$post->getTitle(),
            'date'=>$post->getPostdate(),
            'photo'=>$post->getPhoto(),
            'description'=>$post->getDescription(),
            'id'=>$post->getId(),
            'nbrVue'=>$post->getViews()

        ]);
    }

    /**
     * @Route("/recherche",name="recherche")
     */
    public function Recherche(PostRepository $repository,Request $request){

        $data=$request->get('search');
        $post=$repository->findBy(['title'=>$data]);
        return $this->render('post/AfficherPost.html.twig',
            ['post'=>$post]);

    }
    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/addComment",name="addComment")
     */
    public function addCommentAction(Request $request){
        $ref = $request->headers->get('referer');
        $post=$this->getDoctrine()
            ->getRepository(Post::class)
            ->findPostByid($request->request->get('post_id'));
        $comment = new Postcomment();
        $comment->setPost($post);
        $comment->setComment($request->request->get('comment'));
        $em=$this->getDoctrine()->getManager();
        $em->persist($comment);
        $em->flush();
        $this->addFlash(
            'info', 'comment published'

        );
        return $this->redirect($ref);
    }
    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route ("/addvue",name="addvue")
     */
    function Add(Request $request){
        $ref = $request->headers->get('referer');
        $post=$this->getDoctrine()
            ->getRepository(Vue::class)
            ->findAll();
        $vue=new Vue();
        $form=$this->createForm(VueType::class,$vue);
        $form->handleRequest($request);
        $em=$this->getDoctrine()->getManager();
        $em->persist($vue);
        $em->flush();
        return $this->redirect($ref);


    }



    /**
     * @param VueRepository $repository
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route ("/vue",name="vue")
     */
    public function AfficheViews(VueRepository $repository){
       // $repo=$this->getDoctrine()->getRepository(Views::class);
        $views=$repository->findAll();
        return $this->render('post/AfficherPost.html.twig',
            ['vue'=>$views]);
    }




}
