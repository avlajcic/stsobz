<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Club;
use AppBundle\Form\ClubType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AdminController
 * @package AppBundle\Controller
 * @Route("/admin/clubs", name="club_")
 */
class ClubController extends Controller
{
    /**
     * @Route("/", name="list")
     * @param EntityManagerInterface $em
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(EntityManagerInterface $em)
    {
        $clubs = $em->getRepository('AppBundle:Club')->findAll();
        // replace this example code with whatever you need
        return $this->render('admin/clubs/list.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
            'clubs' => $clubs,
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
        $club = new Club();
        $form = $this->createForm(ClubType::class, $club, array(
        ));

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($club);
            $em->flush();
            return $this->redirect(
                $this->generateUrl('club_list')
            );
        }

        return $this->render('admin/clubs/create.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/{id}/edit", name="edit")
     * @param Club $club
     * @param EntityManagerInterface $em
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Club $club, EntityManagerInterface $em, Request $request)
    {
        $form = $this->createForm(ClubType::class, $club, array(
        ));

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($club);
            $em->flush();

            return $this->redirect(
                $this->generateUrl('club_list')
            );
        }

        return $this->render('admin/clubs/create.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/{id}/delete", name="delete")
     * @param Club $club
     * @param EntityManagerInterface $em
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function deleteAction(Club $club, EntityManagerInterface $em)
    {

        $em->remove($club);
        $em->flush();

        return $this->redirect(
            $this->generateUrl('club_list')
        );

    }
}
