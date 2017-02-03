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
	public function createPlayer(Role $role) {
		$player = new Player();
		$randomUser = json_decode(file_get_contents("https://randomuser.me/api/"))->results[0];
		$player
			->setRole($role)
			->setName($randomUser->name->first . " " . $randomUser->name->last)
		;

		return $player;
	}

	/**
	 * Creates a new player entity with random values (no form).
	 *
	 */
	public function createTeam() {
		$em = $this->getDoctrine()->getManager();
		$roles = $em->getRepository('QuidditchBundle:Role')->findAll();
		$randomUser = json_decode(file_get_contents("https://randomuser.me/api/"))->results[0];
		$teamName = $randomUser->login->username;
		$teamCountry = $randomUser->location->state;
		$team = new Team();
		$team
			->setName($teamName)
			->setCountry($teamCountry)
		;
		foreach ($roles as $role) {
			for ($i = 0; $i < $role->getMaxPerTeam(); ++$i) {
				$team->addPlayer($this->createPlayer($role));
			}
		}

		return $team;
	}
}