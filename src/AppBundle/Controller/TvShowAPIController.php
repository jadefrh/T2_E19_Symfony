<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\JsonResponse;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use AppBundle\Entity\TvShowAPI;

class TvShowAPIController extends Controller
{
    /**
     * @Route("/TvShowAPIs", name="TvShowAPIs_list")
     * @Method({"GET"})
     */
    public function getTvShowAPIsAction(Request $request)
    {
        $TvShowAPIs = $this->get('doctrine.orm.entity_manager')
            ->getRepository('AppBundle:TvShowAPI')
            /*->find($request->get('TvShowAPI_id')); */
            ->findAll();
        /* @var $TvShowAPIs TvShowAPI[] */

        if (empty($TvShowAPI)) {
            return new JsonResponse(['message' => 'Show not found'], Response::HTTP_NOT_FOUND);
        }

        $formatted = [];
        foreach ($TvShowAPIs as $TvShowAPI) {
            $formatted[] = [
                'id' => $TvShowAPI->getId(),
                'title' => $TvShowAPI->getTitle(),
                'host' => $TvShowAPI->getHost(),
                'theme' => $TvShowAPI->getTheme(),
                'time' => $TvShowAPI->getTime(),
                'channel' => $TvShowAPI->getChannel(),
                'description' => $TvShowAPI->getDescription(),
            ];
        }

        return new JsonResponse($formatted);
    }
}