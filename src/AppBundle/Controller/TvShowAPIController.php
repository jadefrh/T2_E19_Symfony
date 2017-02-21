<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\TvShowAPI;

class TvShowAPIController extends Controller
{
    /**
     * @Route("/TvShowAPI", name="tvshow_list")
     * @Method({"GET"})
     */
    public function getTvShowAPIAction(Request $request)
    {
        return new JsonResponse([
            new TvShowAPI("Tour Eiffel", "5 Avenue Anatole France, 75007 Paris"),
            new TvShowAPI("Mont-Saint-Michel", "50170 Le Mont-Saint-Michel"),
            new TvShowAPI("Château de Versailles", "Place d'Armes, 78000 Versailles"),
        ]);
    }
}