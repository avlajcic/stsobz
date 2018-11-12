<?php

namespace AppBundle\Controller;

use AppBundle\Service\GetClubStats;
use AppBundle\Service\GetLeagueRoundsInfo;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     * @param Request $request
     * @param EntityManagerInterface $em
     * @param GetClubStats $getClubStats
     * @param GetLeagueRoundsInfo $leagueRoundsInfo
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function indexAction(Request $request, EntityManagerInterface $em, GetClubStats $getClubStats, GetLeagueRoundsInfo $leagueRoundsInfo)
    {
        $leagues = $em->getRepository('AppBundle:League')->findAll();
        $clubStats = $getClubStats->getStats($leagues);

        $roundsInfo = $leagueRoundsInfo->getRoundsInfo($leagues);

        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
            'leagues' => $leagues,
            'clubStats' => $clubStats,
            'roundInfo' => $roundsInfo
        ]);
    }


}
