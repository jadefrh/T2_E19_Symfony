<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * login controller.
 *
 * @Route("login")
 */
class UserController extends Controller
{
    /**
     * Lists all chevalier entities.
     *
     * @Route("/", name="login")
     * @Method("GET|POST")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $users = $em->getRepository('AppBundle:User')->findAll();

        return $this->render('/FOSUSerBundle/login.html.twig', array(
            'users' => $users,
        ));
    }
}
