<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ImageType;
use App\Form\UserType;
use Twilio\Rest\Client;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class UserController extends AbstractController
{
    /**
     * @Route("/admin/utilisateur", name="utilisateur")
     */
    public function listUsers(): Response
    {
        $users = $this->getDoctrine()->getRepository(User::class)->findAll();
        return $this->render('admin/listuser.html.twig', ['users' => $users]);
    }

    /**
     * @Route ("/admin/deleteusers/{id}",name="deleteUsers")
     */
    public function deleteUsers($id): RedirectResponse
    {
        $users = $this->getDoctrine()->getRepository(User::class)->find($id);
        $em = $this->getDoctrine()->getManager();
        if ($users->getImage() !== null) {
            $filesystem = new Filesystem();
            $filesystem->remove($this->getParameter('images_directory') . '/' . $users->getImage());
        }
        $em->remove($users);
        $em->flush();

        return $this->redirectToRoute("utilisateur");
    }

    /**
     * @Route ("/admin/uploaduserimage/{id}",name="adminuserimage")
     */
    public function uploadUserImage(Request $request, $id)
    {
        $users = $this->getDoctrine()->getRepository(User::class)->find($id);
        $form = $this->createForm(ImageType::class, $users);
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
                        $this->getParameter('images_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'imageFilename' property to store the PDF file name
                // instead of its contents
                if ($users->getImage() !== null) {
                    $filesystem = new Filesystem();
                    $filesystem->remove($this->getParameter('images_directory') . '/' . $users->getImage());
                }
                $users->setImage($newFilename);
                $em = $this->getDoctrine()->getManager();
                $em->flush();
            }

            return $this->redirectToRoute("utilisateur");
        }
        return $this->render("admin/uploadImage.html.twig", ["form" => $form->createView()]);
    }

    /**
     * @Route ("/admin/adduserrole/{id}",name="addUserRole")
     */
    public function addUsersRole($id): RedirectResponse
    {
        $users = $this->getDoctrine()->getRepository(User::class)->find($id);
        $roles = $users->getRoles();
        if (
            in_array('ROLE_ADMIN', $roles, true) &&
            in_array('ROLE_USER', $roles, true) &&
            !in_array('ROLE_SUPER_ADMIN', $roles, true)
        ) {
            $roles[] = "ROLE_SUPER_ADMIN";
        }
        if (in_array('ROLE_USER', $roles, true) && !in_array('ROLE_ADMIN', $roles, true)) {
            $roles[] = "ROLE_ADMIN";
        }
        $users->setRoles($roles);
        $em = $this->getDoctrine()->getManager();
        $em->flush();
        return $this->redirectToRoute("utilisateur");
    }

    /**
     * @Route ("/admin/removeuserrole/{id}",name="removeUserRole")
     */
    public function removeUsersRole($id): RedirectResponse
    {
        $users = $this->getDoctrine()->getRepository(User::class)->find($id);
        $roles = $users->getRoles();
        if (
            in_array('ROLE_ADMIN', $roles, true) &&
            in_array('ROLE_USER', $roles, true) &&
            !in_array('ROLE_SUPER_ADMIN', $roles, true)
        ) {
            $key = array_search("ROLE_ADMIN", $roles, true);
            unset($roles[$key]);
        }
        if (
            in_array('ROLE_ADMIN', $roles, true) &&
            in_array('ROLE_USER', $roles, true) &&
            in_array('ROLE_SUPER_ADMIN', $roles, true)
        ) {
            $key = array_search("ROLE_SUPER_ADMIN", $roles, true);
            unset($roles[$key]);
        }
        $users->setRoles($roles);
        $em = $this->getDoctrine()->getManager();
        $em->flush();
        return $this->redirectToRoute("utilisateur");
    }


    /**
     * @Route("/admin/profile/{id}", name="profile")
     */
    public function listProfile($id): Response
    {
        $profile = $this->getDoctrine()->getRepository(User::class)->find($id);
        return $this->render('admin/profile.html.twig', ['profile' => $profile]);
    }



}