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

    private function mergeAndSortClubStats(&$firstClubArray1, &$firstClubArray2) {
        $result = Array();
        foreach ($firstClubArray1 as &$value_1) {
            $found = false;
            foreach ($firstClubArray2 as $value_2) {
                if($value_1['name'] ==  $value_2['name']) {
                    $found = true;
                    $result[] = array_merge($value_1,$value_2);
                    end($result);
                    $key = key($result);
                    $result[$key]['totalWon'] = $result[$key]['totalHomeWon'] + $result[$key]['totalAwayWon'];
                    $result[$key]['totalLost'] = $result[$key]['totalHomeLost'] + $result[$key]['totalAwayLost'];
                    $result[$key]['totalPoints'] = $result[$key]['totalHomePoints'] + $result[$key]['totalAwayPoints'];
                    $result[$key]['totalWonPoints'] = $result[$key]['totalHomeWonPoints'] + $result[$key]['totalAwayWonPoints'];
                    $result[$key]['totalLostPoints'] = $result[$key]['totalHomeLostPoints'] + $result[$key]['totalAwayLostPoints'];
                }
            }

        }
        $result = array();
        foreach ($firstClubArray1 as $club) {
            $key = $club['name'];
            $result[$key] = array();
            $result[$key]['totalWon'] = $club['totalHomeWon'];
            $result[$key]['totalLost'] = $club['totalHomeLost'];
            $result[$key]['totalPoints'] = $club['totalHomePoints'];
            $result[$key]['totalWonPoints'] = $club['totalHomeWonPoints'];
            $result[$key]['totalLostPoints'] = $club['totalHomeLostPoints'];
            $result[$key]['name'] = $club['name'];
        }
        foreach ($firstClubArray2 as $club) {
            $key = $club['name'];
            if (!isset($result[$key])) {
                $result[$key] = array();
                $result[$key]['totalWon'] = 0;
                $result[$key]['totalLost'] = 0;
                $result[$key]['totalPoints'] = 0;
                $result[$key]['totalWonPoints'] = 0;
                $result[$key]['totalLostPoints'] = 0;
                $result[$key]['name'] = $club['name'];
            }
            $result[$key]['totalWon'] += $club['totalAwayWon'];
            $result[$key]['totalLost'] +=  $club['totalAwayLost'];
            $result[$key]['totalPoints'] +=  $club['totalAwayPoints'];
            $result[$key]['totalWonPoints'] += $club['totalAwayWonPoints'];
            $result[$key]['totalLostPoints'] += $club['totalAwayLostPoints'];
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