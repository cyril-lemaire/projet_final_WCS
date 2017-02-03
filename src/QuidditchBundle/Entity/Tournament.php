<?php

namespace QuidditchBundle\Entity;

/**
 * Tournament
 */
class Tournament
{
	/**
     * @var int
     */
    private $id;

    /**
     * @var \DateTime
     */
    private $date;


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
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Tournament
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $games;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->games = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add game
     *
     * @param \QuidditchBundle\Entity\Game $game
     *
     * @return Tournament
     */
    public function addGame(\QuidditchBundle\Entity\Game $game)
    {
        $this->games[] = $game;

        return $this;
    }

    /**
     * Remove game
     *
     * @param \QuidditchBundle\Entity\Game $game
     */
    public function removeGame(\QuidditchBundle\Entity\Game $game)
    {
        $this->games->removeElement($game);
    }

    /**
     * Get games
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getGames()
    {
        return $this->games;
    }
    /**
     * @var integer
     */
    private $nbTeams;


    /**
     * Set nbTeams
     *
     * @param integer $nbTeams
     *
     * @return Tournament
     */
    public function setNbTeams($nbTeams)
    {
        $this->nbTeams = $nbTeams;

        return $this;
    }

    /**
     * Get nbTeams
     *
     * @return integer
     */
    public function getNbTeams()
    {
        return $this->nbTeams;
    }
}
