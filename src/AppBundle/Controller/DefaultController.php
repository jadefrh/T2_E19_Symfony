<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\Query\ResultSetMappingBuilder;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // connect to bdd and get recent emission
        $em = $this->getDoctrine()->getManager();
        $showsRecent = $em->getRepository('AppBundle:TVShow')->findBy(
          array(),
          array('id' => 'DESC'),
          1,
          0
        );

        //custom query to get the most wtf post
        $qb = $em->createQueryBuilder()
          ->select("COUNT ( vote.show ) as vote_count, t_v_show.name, t_v_show.description ")
          ->from(' AppBundle:TVShow', 't_v_show')
          ->innerJoin(' AppBundle:Vote', 'vote', 'WITH', 't_v_show.id = vote.show')
          ->andWhere("vote.type = 'wtf' ")
          ->groupBy('t_v_show.id')
          ->orderBy('vote_count', 'DESC');
        $qb->setMaxResults(1);
        $topWtf = $qb->getQuery()->getOneOrNullResult();

        //custom query to get the most wtf post
        $qb = $em->createQueryBuilder()
          ->select("COUNT ( vote.show ) as vote_count, t_v_show.name, t_v_show.description ")
          ->from(' AppBundle:TVShow', 't_v_show')
          ->innerJoin(' AppBundle:Vote', 'vote', 'WITH', 't_v_show.id = vote.show')
          ->andWhere("vote.type = 'wtf' ")
          ->groupBy('t_v_show.id')
          ->orderBy('vote_count', 'DESC');
        $qb->setMaxResults(1);
        $topWtf = $qb->getQuery()->getResult();


        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
            'showsRecent' => $showsRecent,
            'topWtf'=> $topWtf,
        ]);
    }
}
