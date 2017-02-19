<?php

namespace QuidditchBundle\Entity;

use Symfony\Component\Validator\Constraints\DateTime;

/**
 * Game
 */
class Game
{
	public function __toString()
	{
		return $this->getTeams()[0] . ' Vs ' . $this->getTeams()[1] . "Winner: " . $this->getWinner();
	}

	/**
	 * Définir l’équipe vainqueur selon les critères suivants:
	 * La note de l’équipe se calcule par la formule suivante :
	 * moyenne de l’exp des joueurs * (moyenne_fatigue/100)
	 * L’équipe la plus jeune voit sa note bonifiée de 10%
	 * L’équipe qui a la note la plus haute gagne
	 */
	public function play(&$team1 = null, &$team2 = null) {
		$score = [0, 0];
		$youngestTeamIndex = $youngestTeamCreationDate = null;
		if ($team1 && $team2) {
			$teams = [$team1, $team2];
		} else {
			$teams = $this->getTeams();
		}
		foreach ($teams as $i => $team) {
			$score[$i] = floatval($team->getTotalExp() * $team->getAverageExhaust()) / (100 * count($team->getPlayers()));
			if ($youngestTeamIndex == null || $team->getCreationDate() > $youngestTeamCreationDate) {
				$youngestTeamCreationDate = $team->getCreationDate();
				$youngestTeamIndex = $i;
			}
		}
		$score[$youngestTeamIndex] *= 1.1;
		$winnerIndex = ($score[0] == $score[1]) ? random_int(0, 1) : $score[1] > $score[0];
		$winner = $teams[$winnerIndex];
		$loser = $teams[!$winnerIndex];
		$this->setWinner($winner);
		$this->setDate(new \DateTime('now'));
		$winner->gainExp(5, 10);
		$loser->gainExp(0, 5);
		foreach ($this->getTeams() as $team) {
			$team->addExhaust(1, 10);
		}
		return $this;
	}

	/**
	 * Constructor
	 */
	public function __construct(Team $team1 = null, Team $team2 = null)
	{
		$this->teams = new \Doctrine\Common\Collections\ArrayCollection();
		if ($team1 && $team2) {
			$this->addTeam($team1)->addTeam($team2);
		}
		$this->date = new \DateTime('now');
	}

	/**
	 * Get loser
	 *
	 * @return \QuidditchBundle\Entity\Team
	 */
	public function getLoser()
	{
		foreach ($this->getTeams() as $team) {
			if ($team != $this->getWinner()) {
				return $team;
			}
		}
	}

	////////////////////
	// GENERATED CODE //
	////////////////////

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
     * @return Game
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
     * @var \QuidditchBundle\Entity\Team
     */
    private $winner;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $teams;

    /**
     * Set winner
     *
     * @param \QuidditchBundle\Entity\Team $winner
     *
     * @return Game
     */
    public function setWinner(\QuidditchBundle\Entity\Team $winner = null)
    {
        $this->winner = $winner;

        return $this;
    }

    /**
     * Get winner
     *
     * @return \QuidditchBundle\Entity\Team
     */
    public function getWinner()
    {
        return $this->winner;
    }

    /**
     * Add team
     *
     * @param \QuidditchBundle\Entity\Team $team
     *
     * @return Game
     */
    public function addTeam(\QuidditchBundle\Entity\Team $team)
    {
        $this->teams[] = $team;

        return $this;
    }

    /**
     * Remove team
     *
     * @param \QuidditchBundle\Entity\Team $team
     */
    public function removeTeam(\QuidditchBundle\Entity\Team $team)
    {
        $this->teams->removeElement($team);
    }

    /**
     * Get teams
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTeams()
    {
        return $this->teams;
    }
}
