<?php

namespace App\Controller;

use App\Entity\Activite;
use App\Entity\Type;
use App\Form\ActiviteType;
use App\Form\TypeType;
use App\Repository\ActiviteRepository;
use App\Repository\TypeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TypeController extends AbstractController
{
    /**
     * @Route("/type", name="type")
     */
    public function index(): Response
    {
        return $this->render('type/index.html.twig', [
            'controller_name' => 'TypeController',
        ]);
    }
    /**
 * @param TypeRepository $repository
 * @return Response
 * @Route("/AfficheType",name="AfficheType")
 */
    public function Affiche(TypeRepository  $repository)
    {
        //$repo=$this->getDoctrine()->getRepository(type::class);
        $type = $repository->findAll();
        return $this->render('type/affiche.html.twig', ['type' => $type]);
    }

    /**
     * @param TypeRepository $repository
     * @return Response
     * @Route("/AfficheTypeclient",name="AfficheTypeclinet")
     */
    public function Afficheclient(TypeRepository  $repository)
    {
        //$repo=$this->getDoctrine()->getRepository(type::class);
        $type = $repository->findAll();
        return $this->render('type/affichagetypeclient.html.twig', ['type' => $type]);
    }

    /**
     * @Route("delete/{id}",name="t")
     */
    function Delete($id, TypeRepository $repository)
    {
        $type = $repository->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($type);
        $em->flush();
        return $this->redirectToRoute('AfficheType');
    }

    /**
     * @Route("/AddType",name="AddType")
     */
    function Add(Request $request)
    {
        $type = new Type();
        $form = $this->createForm(TypeType::class, $type);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($type);
            $em->flush();
        }
        return $this->render('type/add.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @route("type/Update/{id}",name="update")
     */
    function Update(TypeRepository $repository, $id,Request $request)
    {
        $type = $repository->find($id);
        $form = $this->createForm(TypeType::class, $type);
        $form->add('Update', SubmitType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute("AfficheType");
        }
        return $this->render('type/update.html.twig',
            [
                'f' => $form->createView()
            ]);
    }
}
