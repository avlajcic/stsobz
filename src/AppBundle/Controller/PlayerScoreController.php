<?php

namespace AppBundle\Controller;

use AppBundle\Entity\PlayerScore;
use AppBundle\Form\GameMatchType;
use AppBundle\Form\PlayerScoreType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @package AppBundle\Controller
 * @Route("/admin/player-scores", name="player_score_")
 */
class PlayerScoreController extends Controller
{
    /**
     * @Route("/", name="list")
     * @param EntityManagerInterface $em
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(EntityManagerInterface $em)
    {
        $playerScores = $em->getRepository('AppBundle:PlayerScore')->findAll();

        return $this->render('admin/playerScore/list.html.twig', [
            'playerScores' => $playerScores,
        ]);
    }

    /**
     * @Route("/create", name="create")
     * @param EntityManagerInterface $em
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function createAction(EntityManagerInterface $em, Request $request)
    {
        $playerScore = new PlayerScore();
        $form = $this->createForm(PlayerScoreType::class, $playerScore, array());

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($playerScore);
            $em->flush();
            return $this->redirect(
                $this->generateUrl('player_score_list')
            );
        }

        return $this->render('admin/playerScore/create.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/{id}/edit", name="edit")
     * @param PlayerScore $playerScore
     * @param EntityManagerInterface $em
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editAction(PlayerScore $playerScore, EntityManagerInterface $em, Request $request)
    {
        $form = $this->createForm(PlayerScoreType::class, $playerScore, array());

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($playerScore);
            $em->flush();

            return $this->redirect(
                $this->generateUrl('player_score_list')
            );
        }

        return $this->render('admin/playerScore/create.html.twig', array(
            'form' => $form->createView(),
            'playerScore' => $playerScore
        ));
    }

    /**
     * @Route("/{id}/delete", name="delete")
     * @param PlayerScore $playerScore
     * @param EntityManagerInterface $em
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function deleteAction(PlayerScore $playerScore, EntityManagerInterface $em)
    {

        $em->remove($playerScore);
        $em->flush();

        return $this->redirect(
            $this->generateUrl('player_score_list')
        );

    }
}
