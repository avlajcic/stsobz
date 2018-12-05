<?php

namespace AppBundle\Service;

use AppBundle\Entity\League;
use AppBundle\Entity\Round;
use AppBundle\Repository\GameMatchRepository;
use AppBundle\Repository\RoundRepository;
use AppBundle\Repository\SeasonRepository;
use Doctrine\ORM\EntityManagerInterface;

class GetLeagueRoundsInfo
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @param $leagues
     * @return array
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getRoundsInfo($leagues)
    {

        /** @var SeasonRepository $seasonRepository */
        $seasonRepository = $this->em->getRepository('AppBundle:Season');

        $season = $seasonRepository->getActiveSeason();

        /** @var RoundRepository $roundRepository */
        $roundRepository = $this->em->getRepository('AppBundle:Round');

        $roundInfo = array();
        /** @var League $league */
        foreach ($leagues as $league) {
            $leagueId = $league->getId();
            $roundInfo[$leagueId] = array();
            $rounds = $roundRepository->findBy(array('league' => $league, 'season' => $season));

            /** @var Round $round */
            foreach ($rounds as $round) {
                $roundInfo[$leagueId][] = $round;
            }
        }

        return $roundInfo;
    }

}