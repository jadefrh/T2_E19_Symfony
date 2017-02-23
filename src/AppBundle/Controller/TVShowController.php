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
     * @Route("/show/add")
     */
    public function addAction()
    {
        die('hi');
    }

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


        $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('AppBundle:Vote')
        ;

        //HANDLE THE WTF BUTTON

        // search in the Vote table for a instance with type = fav and user = logged in user
        $existingWtfValue = $repository->findBy(
            array(
                'author' => $user->getId(),
                'show' => $show,
                'type' => 'wtf',
            )
        );


        // check if the array is empty, if the user has not WTF the show yet
        if(empty($existingWtfValue))
        {
            $formWTF = $this->createFormBuilder($voteWTF)
                ->add('type', HiddenType::class)
                ->add('save', SubmitType::class, array('label' => 'UNWTF'))
                ->getForm();

            $formWTF->handleRequest($request);

            if ($formWTF->isSubmitted() && $formWTF->isValid()) {
                $voteWTF = $formWTF->getData();
                if ($voteWTF->getType() === 'wtf') {
                    $em->persist($voteWTF);
                    $em->flush();
                }
            }
        }
        //if its not empty, the show has already been liked, we're going to put an UNWTF button
        else if(!empty($existingWtfValue))
        {
            $formWTF = $this->createFormBuilder($voteWTF)
                ->add('type', HiddenType::class)
                ->add('save', SubmitType::class, array('label' => 'WTF'))
                ->getForm();

            $formWTF->handleRequest($request);

            if ($formWTF->isSubmitted() && $formWTF->isValid()) {
                $voteWTF = $formWTF->getData();
                if ($voteWTF->getType() === 'wtf') {
                    $toRemove = $existingWtfValue[0];
                    $toRemoveId = $toRemove->getId();
                    $delete = $em->getRepository('AppBundle:Vote')->find($toRemoveId);
                    $em->remove($delete);
                    $em->flush();
                }
            }
        }

        // FORM LIKE
        $voteLike = new Vote();
        $voteLike->setShow($show);
        $voteLike->setAuthor($user);

        //HANDLE THE LIKE BUTTON

        // search in the Vote table for a instance with type = fav and user = logged in user
        $existingFavValue = $repository->findBy(
            array(
                'author' => $user->getId(),
                'show' => $show,
                'type' => 'fav',
            )
        );


        // check if the array is empty, if the user has not WTF the show yet
        if(empty($existingFavValue))
        {
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
        }
        //if its not empty, the show has already been liked, we're going to put an UNWTF button
        else if(!empty($existingFavValue))
        {
            $formLike = $this->createFormBuilder($voteLike)
                ->add('type', HiddenType::class)
                ->add('save', SubmitType::class, array('label' => 'UNFAV'))
                ->getForm();

            $formLike->handleRequest($request);

            if ($formLike->isSubmitted() && $formLike->isValid()) {
                $voteLike = $formLike->getData();
                if ($voteLike->getType() === 'fav') {
                    $toRemove = $existingFavValue[0];
                    $toRemoveId = $toRemove->getId();
                    $delete = $em->getRepository('AppBundle:Vote')->find($toRemoveId);
                    $em->remove($delete);
                    $em->flush();
                }
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
