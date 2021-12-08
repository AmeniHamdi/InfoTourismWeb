<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StatistiqueController extends AbstractController
{
    /**
     * @Route("Admin/statistique", name="statistique")
     */
    public function statistique(): Response
    {
        $em = $this->getDoctrine()->getManager();

        $queryFaible = $em->createQuery("SELECT count(u) as adm1 FROM App\Entity\Notes u  where u.typeNote='faible' " );
        $faible = $queryFaible->getResult();

        $queryPasMal = $em->createQuery("SELECT count(u) as adm2 FROM App\Entity\Notes u  where u.typeNote='pas mal' " );
        $pasMal = $queryPasMal->getResult();

        $queryMoyen = $em->createQuery("SELECT count(u) as adm3 FROM App\Entity\Notes u  where u.typeNote='moyen' " );
        $moyen = $queryMoyen->getResult();

        $queryExcellent = $em->createQuery("SELECT count(u) as adm4 FROM App\Entity\Notes u  where u.typeNote='excellent' " );
        $excellent = $queryExcellent->getResult();

        return $this->render('admin/statistique.html.twig', ['faible' => $faible,'pasmal' => $pasMal,'moyen' => $moyen,'excellent' => $excellent]);
    }
}
