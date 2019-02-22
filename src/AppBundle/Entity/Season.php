<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Season
 *
 * @ORM\Table(name="season")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\SeasonRepository")
 */
class Season
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
     * @ORM\Column(name="name", type="string", length=255, unique=true)
     */
    private $name;

    /**
     * @var bool
     *
     * @ORM\Column(name="active", type="boolean")
     */
    private $active;

    /**
     * @ORM\OneToMany(targetEntity="Round", mappedBy="season")
     */
    private $rounds;

    /**
     * @ORM\OneToMany(targetEntity="PlayerScore", mappedBy="season")
     */
    private $playerScores;

    /**
     * Constructor
     */
    public function __construct()
    {
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
     * @return Season
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
     * Set active
     *
     * @param boolean $active
     *
     * @return Season
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get active
     *
     * @return boolean
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Add round
     *
     * @param Round $round
     *
     * @return Season
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
     * @return Season
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
