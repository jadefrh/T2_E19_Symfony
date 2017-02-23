<?php
/**
 * Created by PhpStorm.
 * User: astronaught
 * Date: 23/02/2017
 * Time: 00:47
 */

namespace UserBundle\Controller;

use AppBundle\Entity\TVShow;
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
        $shows = $em->getRepository('AppBundle:TVShow')->findAll();
//        dump($shows);exit;

//        foreach($shows as $show){
//            $favVotes = $this->getDoctrine()->getRepository('AppBundle:Vote')->findBy([
//                'show' => $show,
//                'type' => 'fav',
//            ]);
//            $wtfVotes = $this->getDoctrine()->getRepository('AppBundle:Vote')->findBy([
//                'show' => $show,
//                'type' => 'wtf',
//            ]);
//            $wtfCount = count($wtfVotes);
//            $favCount = count($favVotes);
//            dump($wtfCount);exit;
//        }



        return $this->render('@FOSUser/Profile/list.html.twig', array(
            'entities' => $entities,
            'shows' => $shows,
//            'show' => $show,
//            'favCount' => $favCount,
//            'wtfCount' => $wtfCount,
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