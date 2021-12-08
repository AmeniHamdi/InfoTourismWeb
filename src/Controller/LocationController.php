<?php

namespace App\Controller;

use App\Entity\Location;
use App\Entity\User;
use App\Entity\Voiture;
use App\Form\LocationType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twilio\Rest\Client;

class LocationController extends AbstractController
{
    /**
     * @Route("/client/location/{idVoiture}/{idUser}", name="location")
     */
    public function louerVoiture(Request $request, $idVoiture, $idUser): Response
    {
        $location = new Location();
        $voiture = $this->getDoctrine()->getRepository(Voiture::class)->find($idVoiture);
        $user = $this->getDoctrine()->getRepository(User::class)->find($idUser);
        $form = $this->createForm(LocationType::class, $location);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $location->setIdUser($user);
            $location->setPrixTotal($voiture->getPrix() * $form->get('nbrJours')->getData());
            $voiture->setDisponible(false);
            $location->setIdVoiture($voiture);
            $em->persist($voiture);
            $em->persist($location);
            $em->flush();
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('locationvoiture');
        }
        return $this->render("client/louerVoiture.html.twig", ["form" => $form->createView(), "voiture" => $voiture]);
    }

    /**
     * @Route("/client/Panier/{id}", name="panier")
     */
    public function Panier($id): Response
    {
        $panier = $this->getDoctrine()->getRepository(Location::class)->findBy(['idUser' => $id]);
        $voiture = $this->getDoctrine()->getRepository(Voiture::class)->findAll();
        $total = array_sum(array_map(static function (Location $item) {
            return $item->getPrixTotal();
        }, $panier));

        $model = [];
        array_map(static function ($item) use (&$model) {
            $model[$item->getId()] = $item->getModele();
            return $model;
        }, $voiture);

        $image = [];
        array_map(static function ($item) use (&$image) {
            $image[$item->getId()] = $item->getImage();
            return $image;
        }, $voiture);

        return $this->render(
            'client/panier.html.twig',
            [
                'panier' => $panier,
                "total" => $total,
                "model" => $model,
                'image' => $image
            ]);
    }

    /**
     * @Route ("/client/deletePanier/{id}",name="deletePanier")
     */
    public function deletePanier($id): RedirectResponse
    {
        $panier = $this->getDoctrine()->getRepository(Location::class)->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($panier);
        $em->flush();
        $user = $this->getUser();
        $UserId = $user->getId();
        return $this->redirectToRoute("panier", ['id' => $UserId]);
    }

    /**
     * @Route ("/client/sms",name="sms")
     */
    public function sendsms(): RedirectResponse
    {
        $account_sid = $this->getParameter('twilio_sid');
        $auth_token = $this->getParameter('twilio_token');

        $twilio_number = "+19282382457";

        $client = new Client($account_sid, $auth_token);
        $client->messages->create(
            '+21651881010',
            array(
                'from' => $twilio_number,
                'body' => 'Bonjour Madame Ameni, nous vous confirmons la préparation de votre commande et nous vous remercions pour votre confiance ,Info Tourisme vous souhaitant une très bonne journée'
            )
        );
        $user = $this->getUser();
        $UserId = $user->getId();
        return $this->redirectToRoute("panier", ['id' => $UserId]);
    }
}
