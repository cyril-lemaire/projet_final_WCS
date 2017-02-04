<?php

namespace QuidditchBundle\Repository;
use QuidditchBundle\Controller\PlayerController;
use QuidditchBundle\Entity\Player;
use QuidditchBundle\Entity\Role;
use QuidditchBundle\Entity\Team;

/**
 * PlayerRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PlayerRepository extends \Doctrine\ORM\EntityRepository
{
	public function findByPage($page) {
		$qb = $this->createQueryBuilder('p')
			->setFirstResult(max(0, $page - 1) * PlayerController::ITEMS_PER_PAGE)
			->setMaxResults(PlayerController::ITEMS_PER_PAGE)
		;
		return $qb->getQuery()->getResult();
	}

	/*
	public function findAllMappedByRole() {
		// We're gonna save the players in an array of role
		$playersByRole = [];
		$roleNames = array_keys(Team::MAX_PER_ROLE);
		foreach ($roleNames as $roleName) {
			$role = $this->getEntityManager()->getRepository('QuidditchBundle:Role')->findOneBy(['name' => $roleName]);
			$rawPlayers = $this->findByRole($role);
			$playersByRole[$roleName] = [];
			foreach ($rawPlayers as $player) {
				$playersByRole[$roleName][strval($player)] = $player;
			}
		}
		return $playersByRole;
	}
	*/
}
