<?php

namespace AppBundle\Controller;

use AppBundle\Entity\TVShow;
use AppBundle\Entity\Vote;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
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

        //FORM WTF

        $voteWTF = new Vote();

        $user = $this->get('security.token_storage')->getToken()->getUser();

        $voteWTF->setShow($show);
        $voteWTF->setAuthor($user);
        $voteWTF->setType('wtf');

        $formWTF = $this->createFormBuilder($voteWTF)
            ->add('save', SubmitType::class, array('label' => 'WTF'))
            ->getForm();
        $formWTF->handleRequest($request);

        if ($formWTF->isSubmitted() && $formWTF->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $voteWTF = $formWTF->getData();

            // ... perform some action, such as saving the task to the database
            // for example, if Task is a Doctrine entity, save it!
            $em = $this->getDoctrine()->getManager();
            $em->persist($voteWTF);
            $em->flush();




        }

        //FORM LIKE

        $voteLike = new Vote();

        $user = $this->get('security.token_storage')->getToken()->getUser();

        $voteLike->setShow($show);
        $voteLike->setAuthor($user);
        $voteLike->setType('fav');

        $formLike = $this->createFormBuilder($voteLike)
            ->add('save', SubmitType::class, array('label' => 'fav'))
            ->getForm();
        $formLike->handleRequest($request);

        if ($formLike->isSubmitted() && $formLike->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $voteLike = $formLike->getData();

            // ... perform some action, such as saving the task to the database
            // for example, if Task is a Doctrine entity, save it!
            $em = $this->getDoctrine()->getManager();
            $em->persist($voteLike);
            $em->flush();





        }

        $showId = $show->getId();

        $connection = $em->getConnection();
        $statementWtf = $connection->prepare("SELECT * FROM vote WHERE show_id = $showId AND type = 'wtf' ");
        $statementWtf->execute();
        $statementWtf->fetchAll();
        $countWtf = $statementWtf->rowCount();

        $connection = $em->getConnection();
        $statementFav = $connection->prepare("SELECT * FROM vote WHERE show_id = $showId AND type = 'fav' ");
        $statementFav->execute();
        $statementFav->fetchAll();
        $countFav = $statementFav->rowCount();

        return $this->render('AppBundle:TVShow:show.html.twig', array(
            'show' => $show,
            'formWTF' => $formWTF->createView(),
            'formLike' => $formLike->createView(),
            'countFav' => $countFav,
            'countWtf' => $countWtf,
        ));
    }

}
