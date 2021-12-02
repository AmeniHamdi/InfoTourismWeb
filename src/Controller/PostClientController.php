<?php

namespace App\Controller;

use App\Entity\Postcomment;
use App\Form\PostcommentType;
use App\Form\PostType;
use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PostClientController extends AbstractController
{
    /**
     * @Route("/post/client", name="post_client")
     */
    public function index(): Response
    {
        return $this->render('post_client/index.html.twig', [
            'controller_name' => 'PostClientController',
        ]);
    }

    /**
     * @param PostRepository $repository
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route ("/AffichePostCl",name="AffichePostCl")
     */
    public function AfficherPost(PostRepository $repository){
        //$repo=$this->getDoctrine()->getRepository(Classroom::class);
        $post=$repository->findAll();
        return $this->render('post_client/AfficherPostCl.html.twig',
            ['post'=>$post]);
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/DetailPostCl/{id}",name="DetailPostCl")
     */
    function showdetailedAction($id,PostRepository $repository,Request $request){
        $em=$this->getDoctrine()->getManager();
        $post=$repository->find($id);
        $form=$this->createForm(PostType::class,$post);
        $form->add('Detail',SubmitType::class,[
            'attr'=>[
                'class'=>'btn btn-primary waves-effect waves-light']]);

        return $this->render('post_client/detailpostcli.html.twig',
            [
                'title'=>$post->getTitle(),
                'photo'=>$post->getPhoto(),
                'description'=>$post->getDescription(),
                'id'=>$post->getId(),


            ]);
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



}
