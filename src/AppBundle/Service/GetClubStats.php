<?php

namespace AppBundle\Service;


use AppBundle\Entity\League;
use AppBundle\Repository\GameMatchRepository;
use AppBundle\Repository\SeasonRepository;
use Doctrine\ORM\EntityManagerInterface;

class GetClubStats
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
    public function getStats($leagues)
    {
        /** @var GameMatchRepository $gameMatchRepository */
        $gameMatchRepository = $this->em->getRepository('AppBundle:GameMatch');
        /** @var SeasonRepository $seasonRepository */
        $seasonRepository = $this->em->getRepository('AppBundle:Season');

        $season = $seasonRepository->getActiveSeason();

        $clubStats = array();
        /** @var League $league */
        foreach ($leagues as $league) {
            $clubStatsHome = $gameMatchRepository->getClubsHomeStatsForClubsInSeason($league, $season, $league->getClubs());
            $clubStatsAway = $gameMatchRepository->getClubsAwayStatsForClubsInSeason($league, $season, $league->getClubs());
            $clubStats[$league->getId()] = $this->mergeAndSortClubStats($clubStatsHome, $clubStatsAway);
        }

        return $clubStats;
    }

    private function mergeAndSortClubStats(&$firstClubrray1, &$firstClubrray2) {
        $result = Array();
        foreach ($firstClubrray1 as &$value_1) {
            foreach ($firstClubrray2 as $value_2) {
                if($value_1['name'] ==  $value_2['name']) {
                    $result[] = array_merge($value_1,$value_2);
                    end($result);
                    $key = key($result);
                    $result[$key]['totalWon'] = $result[$key]['totalHomeWon'] + $result[$key]['totalAwayWon'];
                    $result[$key]['totalLost'] = $result[$key]['totalHomeLost'] + $result[$key]['totalAwayLost'];
                    $result[$key]['totalPoints'] = $result[$key]['totalHomePoints'] + $result[$key]['totalAwayPoints'];
                }
            }

        }

        usort(
            $result,
            function ($firstClub, $secondClub) {
                return $secondClub['totalPoints'] - $firstClub['totalPoints'];
            }
        );
        return $result;
    }
}