<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\TvShowAPI;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\JsonResponse;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class TvShowAPIController extends Controller
{
    /**
     * @Route("/TvShowAPIs", name="TvShowAPIs_list")
     * @Method({"GET"})
     */

    // Api for TvShow
    public function getTvShowAPIsAction(Request $request)
    {
        $TvShowAPIs = $this->get('doctrine.orm.entity_manager')
            ->getRepository('AppBundle:TvShowAPI')
            ->findAll();
        /* @var $TvShowAPIs TvShowAPI[] */

        if (empty($TvShowAPIs)) {
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


        return new JsonResponse(highlight_string("<?php\n\$formatted =\n" . var_export($formatted, true) . ";\n?>"));
    }
}