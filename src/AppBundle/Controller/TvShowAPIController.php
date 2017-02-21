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
     * @Route("/TvShowAPI/{TvShowAPI_id}", name="tvshow_one")
     * @Method({"GET"})
     */
    public function getTvShowAPIAction(Request $request)
    {
        $shows = $this->get('doctrine.orm.entity_manager')
            ->getRepository('AppBundle:TvShowAPI')
            ->find($request->get('TvShowAPI_id'));
        /* @var $shows TvShowAPI[] */

        if (empty($show)) {
            return new JsonResponse(['message' => 'Show not found'], Response::HTTP_NOT_FOUND);
        }

        $formatted = [];
        foreach ($shows as $show) {
            $formatted[] = [
                'id' => $show->getId(),
                'title' => $show->getTitle(),
                'host' => $show->getHost(),
                'theme' => $show->getTheme(),
                'time' => $show->getTime(),
                'channel' => $show->getChannel(),
                'description' => $show->getDescription(),
            ];
        }

        return new JsonResponse($formatted);
    }
}