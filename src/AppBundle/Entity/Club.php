<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Club
 *
 * @ORM\Table(name="club")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ClubRepository")
 */
class Club
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
     * @ORM\ManyToOne(targetEntity="League", inversedBy="clubs")
     * @ORM\JoinColumn(name="league_id", referencedColumnName="id")
     */
    private $league;

    /**
     * @ORM\OneToMany(targetEntity="GameMatch", mappedBy="homeClub")
     */
    private $gameMatchesHome;

    /**
     * @ORM\OneToMany(targetEntity="GameMatch", mappedBy="awayClub")
     */
    private $gameMatchesAway;
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->gameMatchesHome = new \Doctrine\Common\Collections\ArrayCollection();
        $this->gameMatchesAway = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Club
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
     * Set league
     *
     * @param League $league
     *
     * @return Club
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
     * Add gameMatchesHome
     *
     * @param GameMatch $gameMatchesHome
     *
     * @return Club
     */
    public function addGameMatchesHome(GameMatch $gameMatchesHome)
    {
        $this->gameMatchesHome[] = $gameMatchesHome;

        return $this;
    }

    /**
     * Remove gameMatchesHome
     *
     * @param GameMatch $gameMatchesHome
     */
    public function removeGameMatchesHome(GameMatch $gameMatchesHome)
    {
        $this->gameMatchesHome->removeElement($gameMatchesHome);
    }

    /**
     * Get gameMatchesHome
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getGameMatchesHome()
    {
        return $this->gameMatchesHome;
    }

    /**
     * Add gameMatchesAway
     *
     * @param GameMatch $gameMatchesAway
     *
     * @return Club
     */
    public function addGameMatchesAway(GameMatch $gameMatchesAway)
    {
        $this->gameMatchesAway[] = $gameMatchesAway;

        return $this;
    }

    /**
     * Remove gameMatchesAway
     *
     * @param GameMatch $gameMatchesAway
     */
    public function removeGameMatchesAway(GameMatch $gameMatchesAway)
    {
        $this->gameMatchesAway->removeElement($gameMatchesAway);
    }

    /**
     * Get gameMatchesAway
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getGameMatchesAway()
    {
        return $this->gameMatchesAway;
    }
}
