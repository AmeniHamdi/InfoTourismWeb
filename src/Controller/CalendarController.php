<?php

namespace App\Controller;

use App\Repository\CalendarRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ActiviteRepository;

class CalendarController extends AbstractController
{
    /**
     * @Route("/calendar", name="calendar")
     */
    public function index(CalendarRepository $calendar,ActiviteRepository $repository)
    {

        $list = $repository->findAll();
        return $this->render('calendar/index.html.twig', [
            'list' => $list
        ]);
    }
}
