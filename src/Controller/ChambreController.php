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
use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelHigh;
use Endroid\QrCode\Label\Alignment\LabelAlignmentCenter;
use Endroid\QrCode\Label\Font\NotoSans;
use Endroid\QrCode\RoundBlockSizeMode\RoundBlockSizeModeMargin;
use Endroid\QrCode\Writer\PngWriter;

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
       // $form->add('Ajouter',SubmitType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $Chambre->setIdH(0);
            $Chambre->setRate(0);
            $em->persist($Chambre);
            $data = 'Nombre de lit : '.$Chambre->getNlits().' Prix : '.$Chambre->getPrix().' Etage : '.$Chambre->getEtage().' Numero : '.$Chambre->getNumero().' Hotel Name : '.$Chambre->getHotel()->getNom();
            $result = Builder::create()
                ->writer(new PngWriter())
                ->writerOptions([])
                ->data($data)
                ->encoding(new Encoding('UTF-8'))
                ->errorCorrectionLevel(new ErrorCorrectionLevelHigh())
                ->size(300)
                ->margin(10)
                ->roundBlockSizeMode(new RoundBlockSizeModeMargin())
                ->labelText('Scan me')
                ->labelFont(new NotoSans(20))
                ->labelAlignment(new LabelAlignmentCenter())
                ->build();

// Save it to a file
            $result->saveToFile('C:/xampp/htdocs/Hotel/infoTourisme-main/public/client/qr'.'/qrcode'.$Chambre->getHotel()->getId().'-'.$Chambre->getNumero().'.png');



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
     * @Route("/rate/{id}/{rate}",name="rate")
     */
    function Rate($id,$rate,ChambreRepository  $repository){
        $Chambre=$repository->find($id);
        $em=$this->getDoctrine()->getManager();
        $Chambre->setRate($rate);
        $em->flush();
        return $this->redirectToRoute('AfficheChambreclient');


    }
    /**
     * @Route("chambre/Update/{id}",name="updateChambre")
     */
    function Update(ChambreRepository $repository,$id,Request $request){
        $Chambre=$repository->find($id);
        $form=$this->createForm(ChambreType::class,$Chambre);
        //$form->add('Update',SubmitType::class);
        $form->handleRequest($request);
        if($form->isSubmitted()&& $form->isValid()){
            $em=$this->getDoctrine()->getManager();
            $Chambre->setIdH(0);
            $em->flush();
            return $this->redirectToRoute('AfficheChambre');
        }
        return $this->render('chambre/Update.html.twig',[
            "form"=>$form->createView()
        ]);

    }
}
