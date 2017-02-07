<?php

namespace QuidditchBundle\Services;

use QuidditchBundle\Entity\Player;
use QuidditchBundle\Entity\Role;
use QuidditchBundle\Entity\Team;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\ContainerInterface;

class autoCreate extends Controller
{
	protected $container;

	public function __construct(ContainerInterface $container) {
		$this->container = $container;
	}

	/**
	 * Creates a new player entity with random values (no form).
	 *
	 */
	public function createPlayer(Role $role, $randomUser = null) {
		$player = new Player();
		if (!$randomUser) {
			$randomUser = json_decode(file_get_contents("https://randomuser.me/api/"))->results[0];
		}
		$player
			->setRole($role)
			->setName($randomUser->name->first . " " . $randomUser->name->last)
		;

		return $player;
	}

	/**
	 * Creates a new player entity with random values (no form).
	 *
	 * @param array(User) $randomUsers
	 * @param int $userFirstIndex
	 * @param array(Role) $roles
	 * @return Team
	 */
	public function createTeam(&$randomUsers = null, $userFirstIndex = 0, &$roles = null) {
		$em = $this->getDoctrine()->getManager();
		if (!$roles) {
			$roles = $em->getRepository('QuidditchBundle:Role')->findAll();
		}
		if (!$randomUsers) {
			$playersPerTeam = 0;
			foreach ($roles as $role) {
				$playersPerTeam += $role->getMaxPerTeam();
			}
			$randomUsers = json_decode(file_get_contents('https://randomuser.me/api/?results=' . ($playersPerTeam + 1)))->results;
			$userFirstIndex = 0;
		}
		$i = 0;
		$teamUser = $randomUsers[$userFirstIndex + $i++];
		$teamName = $teamUser->login->username;
		$teamCountry = $teamUser->location->state;

		$team = new Team();
		$team
			->setName($teamName)
			->setCountry($teamCountry)
		;
		foreach ($roles as $role) {
			for ($j = 0; $j < $role->getMaxPerTeam(); ++$j) {
				$team->addPlayer($this->createPlayer($role, $randomUsers[$userFirstIndex + $i++]));
			}
		}

		return $team;
	}
}