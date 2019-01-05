<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * League
 *
 * @ORM\Table(name="league")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\LeagueRepository")
 */
class League
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
     * @ORM\OneToMany(targetEntity="Club", mappedBy="league")
     */
    private $clubs;

    /**
     * @ORM\OneToMany(targetEntity="Round", mappedBy="league")
     */
    private $rounds;

    /**
     * @ORM\OneToMany(targetEntity="PlayerScore", mappedBy="league")
     */
    private $playerScores;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->clubs = new \Doctrine\Common\Collections\ArrayCollection();
        $this->rounds = new \Doctrine\Common\Collections\ArrayCollection();
        $this->playerScores = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return League
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
     * Add club
     *
     * @param Club $club
     *
     * @return League
     */
    public function addClub(Club $club)
    {
        $this->clubs[] = $club;

        return $this;
    }

    /**
     * Remove club
     *
     * @param Club $club
     */
    public function removeClub(Club $club)
    {
        $this->clubs->removeElement($club);
    }

    /**
     * Get clubs
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getClubs()
    {
        return $this->clubs;
    }

    /**
     * Add round
     *
     * @param Round $round
     *
     * @return League
     */
    public function addRound(Round $round)
    {
        $this->rounds[] = $round;

        return $this;
    }

    /**
     * Remove round
     *
     * @param Round $round
     */
    public function removeRound(Round $round)
    {
        $this->rounds->removeElement($round);
    }

    /**
     * Get rounds
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRounds()
    {
        return $this->rounds;
    }

    /**
     * Add playerScore
     *
     * @param PlayerScore $playerScore
     *
     * @return LEague
     */
    public function addPlayerScore(PlayerScore $playerScore)
    {
        $this->playerScores[] = $playerScore;

        return $this;
    }

    /**
     * Remove playerScore
     *
     * @param PlayerScore $playerScore
     */
    public function removePlayerScore(PlayerScore $playerScore)
    {
        $this->playerScores->removeElement($playerScore);
    }

    /**
     * Get playerScores
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPlayerScores()
    {
        return $this->playerScores;
    }
}
