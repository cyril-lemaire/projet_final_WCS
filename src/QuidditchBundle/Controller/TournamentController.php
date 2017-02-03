<?php

namespace QuidditchBundle\Controller;

use QuidditchBundle\Entity\Game;
use QuidditchBundle\Entity\Tournament;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;

/**
 * Tournament controller.
 *
 */
class TournamentController extends Controller
{
	private function isPowerOfTwo($n) {
		if ($n < 2) {
			return false;
		}
		while ($n % 2 == 0) {
			$n /= 2;
		}
		return $n == 1;
	}

    /**
     * Lists all tournament entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $tournaments = $em->getRepository('QuidditchBundle:Tournament')->findAll();

        return $this->render('QuidditchBundle:tournament:index.html.twig', array(
            'tournaments' => $tournaments,
        ));
    }

    /**
     * Creates a new tournament entity.
     *
     */
    public function newAction(Request $request)
    {
        $tournament = new Tournament();
        $form = $this->createForm('QuidditchBundle\Form\TournamentType', $tournament);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
			if ($this->isPowerOfTwo($tournament->getNbTeams())) {
				$em = $this->getDoctrine()->getManager();

				$roles = $em->getRepository('QuidditchBundle:Role')->findAll();
				$playersPerTeam = 0;
				foreach ($roles as $role) {
					$playersPerTeam += $role->getMaxPerTeam();
				}
				$randomUsers = json_decode(file_get_contents(
					'https://randomuser.me/api/?results=' . (($playersPerTeam + 1) * $tournament->getNbTeams())
				))->results;

				$bracket = [];
				for ($i = 0; $i < $tournament->getNbTeams(); ++$i) {
					$bracket[] = $this->get('auto.create')->createTeam(
						array_slice($randomUsers, $i * ($playersPerTeam + 1), $playersPerTeam + 1),
						$roles
					);
				}
				while (count($bracket) > 1) {
					$prevBracket = $bracket;
					$bracket = [];
					for ($i = 0; $i < count($prevBracket) / 2; ++$i) {
						$game = new Game($prevBracket[$i * 2], $prevBracket[($i * 2) + 1]);
						$game->play();

						$bracket[] = $game->getWinner();
						$tournament->addGame($game);
					}
				}
				$em->persist($tournament);
				$em->flush();

				return $this->redirectToRoute('tournament_show', array('id' => $tournament->getId()));
			} else {
				$form->get('nbTeams')->addError(new FormError("Error! nbTeams must be a power of 2 (2, 4, 8, 16... )"));
			}
        }

		return $this->render('QuidditchBundle:tournament:new.html.twig', array(
            'tournament' => $tournament,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a tournament entity.
     *
     */
    public function showAction(Tournament $tournament)
    {
        $deleteForm = $this->createDeleteForm($tournament);

        $i = 1;
        $g = 0;
        $brackets = [];
        $games = $tournament->getGames();
        while ($g < count($games)) {
        	$bracket = [];
        	for ($g2 = 0; $g2 < $tournament->getNbTeams() / pow(2, $i); ++$g2) {
        		$bracket[] = $games[$g + $g2];
			}
			$brackets[] = $bracket;
        	$g += $g2;
        	++$i;
		}

        return $this->render('QuidditchBundle:tournament:show.html.twig', array(
            'tournament' => $tournament,
			'brackets' => $brackets,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a tournament entity.
     *
     */
    public function deleteAction(Request $request, Tournament $tournament)
    {
        $form = $this->createDeleteForm($tournament);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($tournament);
            $em->flush();
        }

        return $this->redirectToRoute('tournament_index');
    }

    /**
     * Creates a form to delete a tournament entity.
     *
     * @param Tournament $tournament The tournament entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Tournament $tournament)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('tournament_delete', array('id' => $tournament->getId())))
            ->setMethod('DELETE')
            ->getForm()

        ;
    }
}
