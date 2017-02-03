<?php

namespace QuidditchBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Team
 */
class Team
{
	/**
	 * Constructor
	 */
	public function __construct()
	{
		$this->players = new \Doctrine\Common\Collections\ArrayCollection();
		$this->dateFormation = new \DateTime('Now');
	}

	public function __toString()
	{
		return $this->getName();
	}

	/**
	 * Add player
	 *
	 * @param \QuidditchBundle\Entity\Player $player
	 *
	 * @return Team
	 */
	public function addPlayer(\QuidditchBundle\Entity\Player $player)
	{
		if ($player->getTeam() == $this) {
			echo "addPlayer: impossible operation, the player $player is already in the team $this!";
		} elseif (($count = count($this->getPlayers($role = $player->getRole()))) < $role->getMaxPerTeam()) {
			$this->players[] = $player->_setTeamWithNoCheck($this);
		} else {
			echo "addPlayer: impossible operation, the player $player can't join the team $this because it already has $count " . $role->getName(). "s!";
		}
		return $this;
	}

	/**
	 * Get players
	 *
	 * @param \QuidditchBundle\Entity\Role|null $role
	 *
	 * @return \Doctrine\Common\Collections\Collection
	 */
	public function getPlayers(Role $role = null)
	{
		if ($role == null)
			return $this->players;
		$res = new ArrayCollection();
		foreach ($this->players as $player) {
			if ($player->getRole() == $role)
				$res[] = $player;
		}
		return $res;
	}

	/**
	 * Set players
	 *
	 * @param array(Player) $players
	 *
	 * @return Team
	 */
	public function setPlayers(array $players)
	{
		$this->players = new \Doctrine\Common\Collections\ArrayCollection();
		foreach ($this->getPlayers() as $player)
			dump($player);
		echo "removed all players! <br/>";
		foreach ($players as $player) {
			$this->addPlayer($player);
		}/*
		dump($this);
		dump($players);
		foreach ($this->getPlayers() as $p)
			dump($p);
		die();*/
		return $this;
	}

	/**
	 * Remove player
	 *
	 * @param \QuidditchBundle\Entity\Player $player
	 */
	public function removePlayer(\QuidditchBundle\Entity\Player $player)
	{
		$this->players->removeElement($player->_setTeamWithNoCheck(null));
	}

	public function getAverageExhaust() {
		$sum = 0;
		foreach ($players = $this->getPlayers() as $player) {
			$sum += $player->getExhaust();
		}
		return floatval($sum) / max(1, count($players));
	}

	public function getTotalExp() {
		$sum = 0;
		foreach ($players = $this->getPlayers() as $player) {
			$sum += $player->getExp();
		}
		return $sum;
	}

	public function gainExp($min, $max) {
		foreach ($players = $this->getPlayers() as $player) {
			$player->addExp(random_int($min, $max));
		}
		return $this;
	}
	public function addExhaust($min, $max) {
		foreach ($players = $this->getPlayers() as $player) {
			$player->addExhaust(random_int($min, $max));
		}
		return $this;
	}

	////////////////////
	// GENERATED CODE //
	////////////////////

    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $country;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $players;

	/**
	 * @var \Doctrine\Common\Collections\Collection
	 */
	private $games;

	/**
	 * @var \Doctrine\Common\Collections\Collection
	 */
	private $wonGames;

	/**
	 * @var \Doctrine\Common\Collections\Collection
	 */
	private $playedGames;

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
     * @return Team
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
     * Set country
     *
     * @param string $country
     *
     * @return Team
     */
    public function setCountry($country)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get country
     *
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Add game
     *
     * @param \QuidditchBundle\Entity\Player $game
     *
     * @return Team
     */
    public function addGame(\QuidditchBundle\Entity\Player $game)
    {
        $this->games[] = $game;

        return $this;
    }

    /**
     * Remove game
     *
     * @param \QuidditchBundle\Entity\Player $game
     */
    public function removeGame(\QuidditchBundle\Entity\Player $game)
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
     * Add wonGame
     *
     * @param \QuidditchBundle\Entity\Game $wonGame
     *
     * @return Team
     */
    public function addWonGame(\QuidditchBundle\Entity\Game $wonGame)
    {
        $this->wonGames[] = $wonGame;

        return $this;
    }

    /**
     * Remove wonGame
     *
     * @param \QuidditchBundle\Entity\Game $wonGame
     */
    public function removeWonGame(\QuidditchBundle\Entity\Game $wonGame)
    {
        $this->wonGames->removeElement($wonGame);
    }

    /**
     * Get wonGames
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getWonGames()
    {
        return $this->wonGames;
    }

    /**
     * Add playedGame
     *
     * @param \QuidditchBundle\Entity\Game $playedGame
     *
     * @return Team
     */
    public function addPlayedGame(\QuidditchBundle\Entity\Game $playedGame)
    {
        $this->playedGames[] = $playedGame;

        return $this;
    }

    /**
     * Remove playedGame
     *
     * @param \QuidditchBundle\Entity\Game $playedGame
     */
    public function removePlayedGame(\QuidditchBundle\Entity\Game $playedGame)
    {
        $this->playedGames->removeElement($playedGame);
    }

    /**
     * Get playedGames
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPlayedGames()
    {
        return $this->playedGames;
    }
    /**
     * @var \DateTime
     */
    private $dateFormation;


    /**
     * Set dateFormation
     *
     * @param \DateTime $dateFormation
     *
     * @return Team
     */
    public function setDateFormation($dateFormation)
    {
        $this->dateFormation = $dateFormation;

        return $this;
    }

    /**
     * Get dateFormation
     *
     * @return \DateTime
     */
    public function getDateFormation()
    {
        return $this->dateFormation;
    }
}
