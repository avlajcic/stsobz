<?php

namespace AppBundle\Controller;

use AppBundle\Entity\GameMatch;
use AppBundle\Form\GameMatchType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AdminController
 * @package AppBundle\Controller
 * @Route("/admin/gameMatches", name="gameMatch_")
 */
class GameMatchController extends Controller
{
    /**
     * @Route("/", name="list")
     * @param EntityManagerInterface $em
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(EntityManagerInterface $em)
    {
        $gameMatches = $em->getRepository('AppBundle:GameMatch')->findAll();
        // replace this example code with whatever you need
        return $this->render('admin/gameMatch/list.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
            'gameMatches' => $gameMatches,
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
        $gameMatch = new GameMatch();
        $form = $this->createForm(GameMatchType::class, $gameMatch, array(
        ));

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($gameMatch);
            $em->flush();
            return $this->redirect(
                $this->generateUrl('gameMatch_list')
            );
        }

        return $this->render('admin/gameMatch/create.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/{id}/edit", name="edit")
     * @param GameMatch $gameMatch
     * @param EntityManagerInterface $em
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editAction(GameMatch $gameMatch, EntityManagerInterface $em, Request $request)
    {
        $form = $this->createForm(GameMatchType::class, $gameMatch, array(
        ));

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($gameMatch);
            $em->flush();

            return $this->redirect(
                $this->generateUrl('gameMatch_list')
            );
        }

        return $this->render('admin/gameMatch/create.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/{id}/delete", name="delete")
     * @param GameMatch $gameMatch
     * @param EntityManagerInterface $em
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function deleteAction(GameMatch $gameMatch, EntityManagerInterface $em)
    {

        $em->remove($gameMatch);
        $em->flush();

        return $this->redirect(
            $this->generateUrl('gameMatch_list')
        );

    }
}
