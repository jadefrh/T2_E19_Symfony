<?php
/**
 * Created by PhpStorm.
 * User: astronaught
 * Date: 23/02/2017
 * Time: 00:47
 */

namespace UserBundle\Controller;

use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class UsersController extends Controller
{
    /**
     * Lists all CategoryShop entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:User')->findAll();

        return $this->render('@FOSUser/Profile/list.html.twig', array(
            'entities' => $entities,
        ));



    }

    /**
     * Finds and displays a CategoryShop entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:User')->find($id);

        return $this->render('@FOSUser/Profile/show.html.twig', array(
            'entity'      => $entity,
        ));
    }
}