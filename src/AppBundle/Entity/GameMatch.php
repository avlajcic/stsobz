<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * GameMatch
 *
 * @ORM\Table(name="game_match")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\GameMatchRepository")
 */
class GameMatch
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Club", inversedBy="gameMatchesHome")
     * @ORM\JoinColumn(name="home_club_id", referencedColumnName="id")
     */
    private $homeClub;

    /**
     * @ORM\ManyToOne(targetEntity="Club", inversedBy="gameMatchesAway")
     * @ORM\JoinColumn(name="away_club_id", referencedColumnName="id")
     */
    private $awayClub;

    /**
     * @var integer
     *
     * @ORM\Column(name="home_club_score", type="integer")
     */
    private $homeClubScore;

    /**
     * @var integer
     *
     * @ORM\Column(name="away_club_score", type="integer")
     */
    private $awayClubScore;

    /**
     * @ORM\ManyToOne(targetEntity="Round", inversedBy="gameMatches")
     * @ORM\JoinColumn(name="round_id", referencedColumnName="id")
     */
    private $round;




    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set homeClubScore
     *
     * @param integer $homeClubScore
     *
     * @return GameMatch
     */
    public function setHomeClubScore($homeClubScore)
    {
        $this->homeClubScore = $homeClubScore;

        return $this;
    }

    /**
     * Get homeClubScore
     *
     * @return integer
     */
    public function getHomeClubScore()
    {
        return $this->homeClubScore;
    }

    /**
     * Set awayClubScore
     *
     * @param integer $awayClubScore
     *
     * @return GameMatch
     */
    public function setAwayClubScore($awayClubScore)
    {
        $this->awayClubScore = $awayClubScore;

        return $this;
    }

    /**
     * Get awayClubScore
     *
     * @return integer
     */
    public function getAwayClubScore()
    {
        return $this->awayClubScore;
    }

    /**
     * Set homeClub
     *
     * @param Club $homeClub
     *
     * @return GameMatch
     */
    public function setHomeClub(Club $homeClub = null)
    {
        $this->homeClub = $homeClub;

        return $this;
    }

    /**
     * Get homeClub
     *
     * @return Club
     */
    public function getHomeClub()
    {
        return $this->homeClub;
    }

    /**
     * Set awayClub
     *
     * @param Club $awayClub
     *
     * @return GameMatch
     */
    public function setAwayClub(Club $awayClub = null)
    {
        $this->awayClub = $awayClub;

        return $this;
    }

    /**
     * Get awayClub
     *
     * @return Club
     */
    public function getAwayClub()
    {
        return $this->awayClub;
    }

    /**
     * Set round
     *
     * @param Round $round
     *
     * @return GameMatch
     */
    public function setRound(Round $round = null)
    {
        $this->round = $round;

        return $this;
    }

    /**
     * Get round
     *
     * @return Round
     */
    public function getRound()
    {
        return $this->round;
    }
}
