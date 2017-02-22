<?php

namespace AppBundle\Controller;

use AppBundle\Entity\TVShow;
use AppBundle\Entity\Vote;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\JsonResponse;
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
    public function showAction(Request $request, TVShow $show)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $em = $this->getDoctrine()->getManager();

        // FORM WTF
        $voteWTF = new Vote();
        $voteWTF->setShow($show);
        $voteWTF->setAuthor($user);

        $formWTF = $this->createFormBuilder($voteWTF)
            ->add('type', HiddenType::class)
            ->add('save', SubmitType::class, array('label' => 'WTF'))
            ->getForm();

        $formWTF->handleRequest($request);

        if ($formWTF->isSubmitted() && $formWTF->isValid()) {
            $voteWTF = $formWTF->getData();
            if ($voteWTF->getType() === 'wtf') {
                $em->persist($voteWTF);
                $em->flush();
            }
        }

        //FORM LIKE
        $voteLike = new Vote();
        $voteLike->setShow($show);
        $voteLike->setAuthor($user);

        $formLike = $this->createFormBuilder($voteLike)
            ->add('type', HiddenType::class)
            ->add('save', SubmitType::class, array('label' => 'FAV'))
            ->getForm();

        $formLike->handleRequest($request);

        if ($formLike->isSubmitted() && $formLike->isValid()) {
            $voteLike = $formLike->getData();
            if ($voteLike->getType() === 'fav') {
                $em->persist($voteLike);
                $em->flush();
            }
        }

        $allWtfVotes = $this->getDoctrine()->getRepository('AppBundle:Vote')->findBy([
            'show' => $show,
            'type' => 'wtf',
        ]);
        $wtfCount = count($allWtfVotes);

        $allFavVotes = $this->getDoctrine()->getRepository('AppBundle:Vote')->findBy([
            'show' => $show,
            'type' => 'fav',
        ]);
        $favCount = count($allFavVotes);

        return $this->render('AppBundle:TVShow:show.html.twig', array(
            'show' => $show,
            'formWTF' => $formWTF->createView(),
            'formLike' => $formLike->createView(),
            'countFav' => $favCount,
            'countWtf' => $wtfCount,
        ));
    }

}
