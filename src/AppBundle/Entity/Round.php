<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Round
 *
 * @ORM\Table(name="round")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\RoundRepository")
 */
class Round
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
     * @ORM\ManyToOne(targetEntity="Season", inversedBy="rounds")
     * @ORM\JoinColumn(name="season_id", referencedColumnName="id")
     */
    private $season;

    /**
     * @ORM\ManyToOne(targetEntity="League", inversedBy="rounds")
     * @ORM\JoinColumn(name="league_id", referencedColumnName="id")
     */
    private $league;

    /**
     * @ORM\OneToMany(targetEntity="GameMatch", mappedBy="round")
     */
    private $gameMatches;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->gameMatches = new \Doctrine\Common\Collections\ArrayCollection();
    }

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
     * Set name
     *
     * @param string $name
     *
     * @return Round
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
     * Set season
     *
     * @param Season $season
     *
     * @return Round
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
     * @return Round
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

    /**
     * Add gameMatch
     *
     * @param GameMatch $gameMatch
     *
     * @return Round
     */
    public function addGameMatch(GameMatch $gameMatch)
    {
        $this->gameMatches[] = $gameMatch;

        return $this;
    }

    /**
     * Remove gameMatch
     *
     * @param GameMatch $gameMatch
     */
    public function removeGameMatch(GameMatch $gameMatch)
    {
        $this->gameMatches->removeElement($gameMatch);
    }

    /**
     * Get gameMatches
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getGameMatches()
    {
        return $this->gameMatches;
    }
}
