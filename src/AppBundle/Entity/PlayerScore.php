<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PlayerScore
 *
 * @ORM\Table(name="player_score")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PlayerScoreRepository")
 */
class PlayerScore
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
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var int
     *
     * @ORM\Column(name="won", type="integer")
     */
    private $won;

    /**
     * @var int
     *
     * @ORM\Column(name="lost", type="integer")
     */
    private $lost;

    /**
     * @ORM\ManyToOne(targetEntity="Season", inversedBy="playerScores")
     * @ORM\JoinColumn(name="season_id", referencedColumnName="id")
     */
    private $season;

    /**
     * @ORM\ManyToOne(targetEntity="League", inversedBy="playerScores")
     * @ORM\JoinColumn(name="league_id", referencedColumnName="id")
     */
    private $league;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return PlayerScore
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set won
     *
     * @param integer $won
     *
     * @return PlayerScore
     */
    public function setWon($won)
    {
        $this->won = $won;

        return $this;
    }

    /**
     * Get won
     *
     * @return int
     */
    public function getWon()
    {
        return $this->won;
    }

    /**
     * Set lost
     *
     * @param integer $lost
     *
     * @return PlayerScore
     */
    public function setLost($lost)
    {
        $this->lost = $lost;

        return $this;
    }

    /**
     * Get lost
     *
     * @return int
     */
    public function getLost()
    {
        return $this->lost;
    }

    /**
     * Set season
     *
     * @param Season $season
     *
     * @return PlayerScore
     */
    public function setSeason(Season $season = null)
    {
        $this->season = $season;

        return $this;
    }

    /**
     * Get season
     *
     * @return Season
     */
    public function getSeason()
    {
        return $this->season;
    }

    /**
     * Set league
     *
     * @param League $league
     *
     * @return PlayerScore
     */
    public function setLeague(League $league = null)
    {
        $this->league = $league;

        return $this;
    }

    /**
     * Get league
     *
     * @return League
     */
    public function getLeague()
    {
        return $this->league;
    }
}

