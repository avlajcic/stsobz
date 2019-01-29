<?php

namespace AppBundle\Service;


use AppBundle\Entity\League;
use AppBundle\Entity\PlayerScore;
use AppBundle\Entity\Round;
use AppBundle\Repository\GameMatchRepository;
use AppBundle\Repository\PlayerScoreRepository;
use AppBundle\Repository\RoundRepository;
use AppBundle\Repository\SeasonRepository;
use Doctrine\ORM\EntityManagerInterface;

class StatsService
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
    public function getClubStats($leagues)
    {
        /** @var GameMatchRepository $gameMatchRepository */
        $gameMatchRepository = $this->em->getRepository('AppBundle:GameMatch');
        $season = $this->getActiveSeason();


        $clubStats = array();
        /** @var League $league */
        foreach ($leagues as $league) {
            $clubStatsHome = $gameMatchRepository->getClubsHomeStatsForClubsInSeason($league, $season, $league->getClubs());
            $clubStatsAway = $gameMatchRepository->getClubsAwayStatsForClubsInSeason($league, $season, $league->getClubs());
            $clubStats[$league->getId()] = $this->mergeAndSortClubStats($clubStatsHome, $clubStatsAway);
        }

        return $clubStats;
    }

    /**
     * @param $leagues
     * @return array
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getRoundsInfo($leagues)
    {
        $season = $this->getActiveSeason();

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

    /**
     * @param $leagues
     * @return array
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getPlayersInfo($leagues)
    {
        $season = $this->getActiveSeason();
        /** @var PlayerScoreRepository $playerScoresRepository */
        $playerScoresRepository = $this->em->getRepository('AppBundle:PlayerScore');

        $playerInfo = array();
        /** @var League $league */
        foreach ($leagues as $league) {
            $leagueId = $league->getId();
            $players = $playerScoresRepository->findBy(array('league' => $league, 'season' => $season));
            $sortedPlayers = $this->sortPlayers($players);
            $playerInfo[$leagueId] = $sortedPlayers;

        }

        return $playerInfo;
    }

    /**
     * @return mixed
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    private function getActiveSeason()
    {
        /** @var SeasonRepository $seasonRepository */
        $seasonRepository = $this->em->getRepository('AppBundle:Season');
        $season = $seasonRepository->getActiveSeason();

        return $season;
    }

    private function mergeAndSortClubStats(&$firstClubArray1, &$firstClubArray2)
    {
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
            $result[$key]['totalLost'] += $club['totalAwayLost'];
            $result[$key]['totalPoints'] += $club['totalAwayPoints'];
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

    private function sortPlayers($players)
    {
        usort(
            $players,
            function ($firstPlayer, $secondPlayer) {
                if ($secondPlayer->getWon() == $firstPlayer->getWon())
                    // sort by lowest number of loses if wins are same
                    return $firstPlayer->getLost() - $secondPlayer->getLost();
                // sort by highest number of wins
                return $secondPlayer->getWon() - $firstPlayer->getWon();
            }
        );

        return $players;
    }
}