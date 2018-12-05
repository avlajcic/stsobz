<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Season;
use AppBundle\Form\SeasonType;
use AppBundle\Service\ChangeActiveSeason;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AdminController
 * @package AppBundle\Controller
 * @Route("/admin/seasons", name="season_")
 */
class SeasonController extends Controller
{
    /**
     * @Route("/", name="list")
     * @param Request $request
     * @param EntityManagerInterface $em
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request, EntityManagerInterface $em)
    {
        $seasons = $em->getRepository('AppBundle:Season')->findAll();
        // replace this example code with whatever you need
        return $this->render('admin/seasons/list.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
            'seasons' => $seasons,
        ]);
    }

    /**
     * @Route("/create", name="create")
     * @param EntityManagerInterface $em
     * @param Request $request
     * @param ChangeActiveSeason $changeActiveSeason
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function createAction(EntityManagerInterface $em, Request $request, ChangeActiveSeason $changeActiveSeason)
    {
        $season = new Season();
        $form = $this->createForm(SeasonType::class, $season, array(
        ));

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($season->getActive()) {
                $changeActiveSeason->checkAndChangeActiveSeason($season);
            }
            $em->persist($season);
            $em->flush();
            return $this->redirect(
                $this->generateUrl('season_list')
            );
        }

        return $this->render('admin/seasons/create.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/{id}/edit", name="edit")
     * @param Season $season
     * @param EntityManagerInterface $em
     * @param Request $request
     * @param ChangeActiveSeason $changeActiveSeason
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Season $season, EntityManagerInterface $em, Request $request, ChangeActiveSeason $changeActiveSeason)
    {
        $form = $this->createForm(SeasonType::class, $season, array(
        ));

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($season->getActive()) {
                $changeActiveSeason->checkAndChangeActiveSeason($season);
            }
            $em->persist($season);
            $em->flush();

            return $this->redirect(
                $this->generateUrl('season_list')
            );
        }

        return $this->render('admin/seasons/create.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/{id}/delete", name="delete")
     * @param Season $season
     * @param EntityManagerInterface $em
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function deleteAction(Season $season, EntityManagerInterface $em)
    {

        $em->remove($season);
        $em->flush();

        return $this->redirect(
            $this->generateUrl('season_list')
        );

    }
}
