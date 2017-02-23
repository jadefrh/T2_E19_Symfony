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
        $topWtf = $qb->getQuery()->getResult();

        //custom query to get the most liked post
        $reqLiked = $em->createQueryBuilder()
          ->select("COUNT ( vote.show ) as vote_count, t_v_show.name, t_v_show.description ")
          ->from(' AppBundle:TVShow', 't_v_show')
          ->innerJoin(' AppBundle:Vote', 'vote', 'WITH', 't_v_show.id = vote.show')
          ->andWhere("vote.type = 'fav' ")
          ->groupBy('t_v_show.id')
          ->orderBy('vote_count', 'DESC');
        $reqLiked->setMaxResults(1);
        $topLiked = $reqLiked->getQuery()->getResult();


        //custom query to get the most commented post
        $reqCommented = $em->createQueryBuilder()
          ->select("COUNT ( comment.showId ) as comment_count, t_v_show.name, t_v_show.description ")
          ->from(' AppBundle:TVShow', 't_v_show')
          ->innerJoin(' AppBundle:Comment', 'comment', 'WITH', 't_v_show.id = comment.showId')
          ->groupBy('t_v_show.id')
          ->orderBy('comment_count', 'DESC');
        $reqCommented->setMaxResults(1);
        $topCommented = $reqCommented->getQuery()->getResult();

        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
            'showsRecent' => $showsRecent,
            'topWtf'=> $topWtf,
            'topLiked' =>$topLiked,
            'topCommented' => $topCommented,
        ]);
    }



}
