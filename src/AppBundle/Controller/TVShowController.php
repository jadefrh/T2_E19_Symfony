<?php

namespace AppBundle\Controller;

use AppBundle\Entity\TVShow;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Student controller.
 *
 * @Route("/")
 */
class TVShowController extends Controller
{

    /**
     * @Route("/show/{name}")
     */
    public function showAction(TVShow $show)
    {
        return $this->render('AppBundle:TVShow:show.html.twig', array(
            'show' => $show,
        ));
    }

}
