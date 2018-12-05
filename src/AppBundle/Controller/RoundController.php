<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Round;
use AppBundle\Form\RoundType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AdminController
 * @package AppBundle\Controller
 * @Route("/admin/rounds", name="round_")
 */
class RoundController extends Controller
{
    /**
     * @Route("/", name="list")
     * @param EntityManagerInterface $em
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(EntityManagerInterface $em)
    {
        $rounds = $em->getRepository('AppBundle:Round')->findAll();
        // replace this example code with whatever you need
        return $this->render('admin/rounds/list.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
            'rounds' => $rounds,
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
        $round = new Round();
        $form = $this->createForm(RoundType::class, $round, array(
        ));

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($round);
            $em->flush();
            return $this->redirect(
                $this->generateUrl('round_list')
            );
        }

        return $this->render('admin/rounds/create.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/{id}/edit", name="edit")
     * @param Round $round
     * @param EntityManagerInterface $em
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Round $round, EntityManagerInterface $em, Request $request)
    {
        $form = $this->createForm(RoundType::class, $round, array(
        ));

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($round);
            $em->flush();

            return $this->redirect(
                $this->generateUrl('round_list')
            );
        }

        return $this->render('admin/rounds/create.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/{id}/delete", name="delete")
     * @param Round $round
     * @param EntityManagerInterface $em
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function deleteAction(Round $round, EntityManagerInterface $em)
    {

        $em->remove($round);
        $em->flush();

        return $this->redirect(
            $this->generateUrl('round_list')
        );

    }
}
