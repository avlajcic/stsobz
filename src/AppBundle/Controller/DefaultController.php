<?php

namespace AppBundle\Controller;

use AppBundle\Service\StatsService;
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
     * @param StatsService $statsService
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function indexAction(Request $request, EntityManagerInterface $em, StatsService $statsService)
    {
        $leagues = $em->getRepository('AppBundle:League')->findAll();

        $clubStats = $statsService->getClubStats($leagues);
        $roundsInfo = $statsService->getRoundsInfo($leagues);
        $playersInfo = $statsService->getPlayersInfo($leagues);


        return $this->render('default/index.html.twig', [
            'leagues' => $leagues,
            'clubStats' => $clubStats,
            'roundInfo' => $roundsInfo,
            'playersInfo' => $playersInfo
        ]);
    }


}
