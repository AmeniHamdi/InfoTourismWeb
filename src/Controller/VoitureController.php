<?php

namespace App\Controller;

use App\Entity\Voiture;
use App\Form\VoitureType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class VoitureController extends AbstractController
{
    /**
     * @Route("/admin/voiture", name="voiture")
     */
    public function listeVoiture(): Response
    {
        $voiture = $this->getDoctrine()->getRepository(Voiture::class)->findAll();
        return $this->render('admin/listeVoiture.html.twig', ['voiture' => $voiture]);
    }

    /**
     * @Route("/admin/addVoiture", name="newVoiture")
     */
    public function addVoiture(Request $request)
    {
        $voiture = new Voiture();
        $form = $this->createForm(VoitureType::class, $voiture);
        $form->handleRequest($request);
        $voiture->setDisponible(true);
        if ($form->isSubmitted() && $form->isValid()) {

            /** @var UploadedFile $imageFile */
            $imageFile = $form->get('image')->getData();

            // this condition is needed because the 'image' field is not required
            // so the PDF file must be processed only when a file is uploaded
            if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalFilename);
                $newFilename = $safeFilename . '-' . uniqid('', true) . '.' . $imageFile->guessExtension();


                // Move the file to the directory where images are stored
                try {
                    $imageFile->move(
                        $this->getParameter('images_voiture_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }
                $voiture->setImage($newFilename);
            }

            $em = $this->getDoctrine()->getManager();
            $em->persist($voiture);
            $em->flush();
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('voiture');
        }
        return $this->render("admin/addVoiture.html.twig", array("form" => $form->createView()));
    }

    /**
     * @Route ("/admin/deleteVoiture/{id}",name="deleteVoiture")
     */
    public
    function deleteVoiture($id)
    {
        $voiture = $this->getDoctrine()->getRepository(Voiture::class)->find($id);
        $em = $this->getDoctrine()->getManager();
        if ($voiture->getImage() !== null) {
            $filesystem = new Filesystem();
            $filesystem->remove($this->getParameter('images_directory') . '/' . $voiture->getImage());
        }
        $em->remove($voiture);
        $em->flush();
        return $this->redirectToRoute("voiture");
    }

    /**
     * @Route("/admin/updateVoiture/{id}",name="updateVoiture")
     */
    public function updateVoiture(Request $request, $id)
    {
        $voiture = $this->getDoctrine()->getRepository(Voiture::class)->find($id);
        $form = $this->createForm(VoitureType::class, $voiture);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            /** @var UploadedFile $imageFile */
            $imageFile = $form->get('image')->getData();

            // this condition is needed because the 'image' field is not required
            // so the PDF file must be processed only when a file is uploaded
            if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalFilename);
                $newFilename = $safeFilename . '-' . uniqid('', true) . '.' . $imageFile->guessExtension();


                // Move the file to the directory where images are stored
                try {
                    $imageFile->move(
                        $this->getParameter('images_voiture_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }
                if ($voiture->getImage() !== null) {
                    $filesystem = new Filesystem();
                    $filesystem->remove($this->getParameter('images_voiture_directory') . '/' . $voiture->getImage());
                }
                $voiture->setImage($newFilename);
            }
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute("voiture");
        }
        return $this->render("admin/updateVoiture.html.twig", ["form" => $form->createView()]);
    }
}
