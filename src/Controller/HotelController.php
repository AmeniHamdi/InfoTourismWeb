<?php

namespace App\Controller;

use App\Data\SearchData;
use App\Entity\Hotel;
use App\Form\HotelType;
use App\Form\SearchFormType;
use App\Repository\HotelRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class HotelController extends AbstractController
{
    /**
     * @Route("/hotel", name="hotel")
     */
    public function index(): Response
    {
        return $this->render('hotel/index.html.twig', [
            'controller_name' => 'HotelController',
        ]);
    }

    /**
     * @param HotelRepository $repository
     * @return Response
     * @Route("/AfficheHotel",name="AfficheHotel")
     */
    public function Affiche(HotelRepository $repository){
        //$repo=$this->getDoctrine()->getRepository(Hotel::class);
        $hotel=$repository->findAll();
        return $this->render('hotel/Affiche.html.twig',['hotel'=>$hotel]);

}
    /**
     * @param HotelRepository $repository
     * @return Response
     * @Route("/AfficheHotelClient",name="AfficheHotelClient")
     */
    public function AfficheHotelClient(HotelRepository $repository,Request $request){
        //$repo=$this->getDoctrine()->getRepository(Hotel::class);

        $data = new SearchData();
        $form = $this->createForm(SearchFormType::class, $data);
        $form->handleRequest($request);
        $hotel= $repository->findSearch($data);


        return $this->render('hotel/affichageHotelCLient.html.twig',['hotel'=>$hotel,
        'form' => $form->createView(),
    ]);

    }
/**
 * @Route("/Supp/{id}",name="d")
 */
function Delete($id,HotelRepository $repository){
    $hotel=$repository->find($id);
    $em=$this->getDoctrine()->getManager();
    $em->remove($hotel);
    $em->flush();
    return $this->redirectToRoute('AfficheHotel');

}

    /**
     * @param Request $request
     * @return Response
     * @Route("/addhotel",name="addhotel")
     */
function ADD(Request $request ){
    $hotel=new Hotel();
    $form=$this->createForm(HotelType::class,$hotel);
    //$form->add('Ajouter',SubmitType::class);
    $form->handleRequest($request);

    if($form->isSubmitted() && $form->isValid()){
        $em=$this->getDoctrine()->getManager();
        $em->persist($hotel);
        $em->flush();
        return $this->redirectToRoute('AfficheHotel');
    }
    return $this->render('hotel/Add.html.twig',[
        'form'=>$form->createView()
    ]);


}
/**
 * @Route("hotel/Update/{id}",name="update")
 */
function Update(HotelRepository $repository,$id,Request $request){
    $hotel=$repository->find($id);
    $form=$this->createForm(HotelType::class,$hotel);
    $form->add('Update',SubmitType::class);
    $form->handleRequest($request);
    if($form->isSubmitted()&& $form->isValid()){
        $em=$this->getDoctrine()->getManager();
        $em->flush();
        return $this->redirectToRoute('AfficheHotel');
    }
    return $this->render('hotel/Update.html.twig',[
        'f'=>$form->createView()
    ]);

}
}
