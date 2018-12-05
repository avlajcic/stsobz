<?php

namespace AppBundle\Controller;

use AppBundle\Entity\League;
use AppBundle\Form\LeagueType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AdminController
 * @package AppBundle\Controller
 * @Route("/admin/leagues", name="league_")
 */
class LeagueController extends Controller
{
    /**
     * @Route("/", name="list")
     * @param Request $request
     * @param EntityManagerInterface $em
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request, EntityManagerInterface $em)
    {
        $leagues = $em->getRepository('AppBundle:League')->findAll();
        // replace this example code with whatever you need
        return $this->render('admin/leagues/list.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
            'leagues' => $leagues,
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
        $league = new League();
        $form = $this->createForm(LeagueType::class, $league, array(
        ));

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $em->persist($league);
            $em->flush();
            return $this->redirect(
                $this->generateUrl('league_list')
            );
        }

        return $this->render('admin/leagues/create.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/{id}/edit", name="edit")
     * @param League $league
     * @param EntityManagerInterface $em
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editAction(League $league, EntityManagerInterface $em, Request $request)
    {
        $form = $this->createForm(LeagueType::class, $league, array(
        ));

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($league);
            $em->flush();

            return $this->redirect(
                $this->generateUrl('league_list')
            );
        }

        return $this->render('admin/leagues/create.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/{id}/delete", name="delete")
     * @param League $league
     * @param EntityManagerInterface $em
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function deleteAction(League $league, EntityManagerInterface $em)
    {

        $em->remove($league);
        $em->flush();

        return $this->redirect(
            $this->generateUrl('league_list')
        );

    }
}
