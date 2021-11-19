<?php

namespace App\Controller;

use App\Entity\Chambre;
use App\Form\ChambreType;
use App\Repository\ChambreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ChambreController extends AbstractController
{
    /**
     * @Route("/chambre", name="chambre")
     */
    public function index(): Response
    {
        return $this->render('chambre/index.html.twig', [
            'controller_name' => 'ChambreController',
        ]);
    }
    /**
     * @Route("/addChambre", name="addChambre")
     */
    public function addChambre(Request $request)
    {
        $Chambre = new Chambre();
        $form = $this->createForm(ChambreType::class, $Chambre);
        $form->add('Ajouter',SubmitType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();
            $Chambre->setIdH(0);
            $em->persist($Chambre);
            $em->flush();
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('AfficheChambre');
        }
        return $this->render("chambre/add.html.twig", array("form" => $form->createView()));
    }
    /**
     * @param ChambreRepository $repository
     * @return Response
     * @Route("/AfficheChambre",name="AfficheChambre")
     */
    public function Affiche(ChambreRepository $repository){
        //$repo=$this->getDoctrine()->getRepository(Chambre::class);
        $chambre=$repository->findAll();

        return $this->render('chambre/AfficheS.html.twig',['chambre'=>$chambre]);


    }
    /**
     * @param ChambreRepository $repository
     * @return Response
     * @Route("/AfficheChambreclient",name="AfficheChambreclient")
     */
    public function AfficheChambreclient(ChambreRepository $repository){
        //$repo=$this->getDoctrine()->getRepository(Chambre::class);
        $chambre=$repository->findAll();

        return $this->render('chambre/affichageClient.html.twig',['chambre'=>$chambre]);


    }
    /**
     * @Route("/deleteChambre/{id}",name="delete")
     */
    function Delete($id,ChambreRepository  $repository){
        $Chambre=$repository->find($id);
        $em=$this->getDoctrine()->getManager();
        $em->remove($Chambre);
        $em->flush();

        return $this->redirectToRoute('AfficheChambre');

    }
    /**
     * @Route("chambre/Update/{id}",name="updateChambre")
     */
    function Update(ChambreRepository $repository,$id,Request $request){
        $Chambre=$repository->find($id);
        $form=$this->createForm(ChambreType::class,$Chambre);
        $form->add('Update',SubmitType::class);
        $form->handleRequest($request);
        if($form->isSubmitted()&& $form->isValid()){
            $em=$this->getDoctrine()->getManager();
            $Chambre->setIdH(0);
            $em->flush();
            return $this->redirectToRoute('AfficheChambre');
        }
        return $this->render('chambre/Update.html.twig',[
            'f'=>$form->createView()
        ]);

    }
}
