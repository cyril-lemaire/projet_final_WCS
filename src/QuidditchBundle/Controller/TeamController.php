<?php

namespace QuidditchBundle\Controller;

use QuidditchBundle\Entity\Team;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;

/**
 * Team controller.
 *
 */
class TeamController extends Controller
{
	/**
	 * Generates a complete TeamForm for a Team (gathers all possible Players for each Role and defaults to the current's Team Players)
	 * @param Team $team
	 * @return Form
	 */
	private function createTeamForm(Team &$team) {
		$em = $this->getDoctrine()->getManager();
		$form = $this->createForm('QuidditchBundle\Form\TeamType', $team);
		$roles = $em->getRepository('QuidditchBundle:Role')->findAll();
		$playerIndex = 0;
		foreach ($roles as $role) {
			$teamPlayers = $team->getPlayers($role);
			for ($i = 0; $i < $role->getMaxPerTeam(); ++$i) {
				$label = $role . ($role->getMaxPerTeam() > 1 ? ' ' . strval($i + 1) : '');
				$form->add('player' . $playerIndex++, EntityType::class, array(
					'label' => $label,
					'class' => 'QuidditchBundle:Player',
					'choices' => $em->getRepository('QuidditchBundle:Player')->findByRole($role),
					'data' => $teamPlayers[$i],
					'mapped' => false,
				));
			}
		}
		return $form;
	}

	/**
	 * Generates FormErrors if any and returns true if no error was found (false otherwise)
	 * @param Form $form
	 * @return bool isValid
	 */
	private function validateTeamForm(Form &$form) {
		$players = [];
		$roles = $this->getDoctrine()->getManager()->getRepository('QuidditchBundle:Role')->findAll();
		$maxPlayersPerTeam = 0;
		foreach ($roles as $role) {
			$maxPlayersPerTeam += $role->getMaxPerTeam();
		}
		for ($i = 0; $i < $maxPlayersPerTeam; ++$i) {
			$field = 'player' . $i;
			$player = $form->get($field)->getData();
			if (in_array($player, $players)) {
				$form->addError(new FormError('You cannot add the player ' . $player . ' twice!'));
				return false;
			}
			$players[] = $player;
		}
		$form->getData()->setPlayers($players);
		return true;
	}

    /**
     * Lists all team entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $teams = $em->getRepository('QuidditchBundle:Team')->findAll();

        return $this->render('QuidditchBundle:team:index.html.twig', array(
            'teams' => $teams,
        ));
    }

    /**
     * Creates a new team entity.
     *
     */
    public function newAction(Request $request)
    {
        $team = new Team();
        $form = $this->createTeamForm($team);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid() && $this->validateTeamForm($form)) {
			$em = $this->getDoctrine()->getManager();
			$em->persist($team);
			$em->flush();

			return $this->redirectToRoute('team_show', array('id' => $team->getId()));
        }

        return $this->render('QuidditchBundle:team:new.html.twig', array(
            'team' => $team,
            'form' => $form->createView(),
        ));
    }

	/**
	 * Creates a new team entity.
	 *
	 */
	public function autocreateAction()
	{
		$em = $this->getDoctrine()->getManager();
		$team = $this->get('auto.create')->createTeam();

		$em->persist($team);
		$em->flush();

		return $this->redirectToRoute('team_show', array('id' => $team->getId()));
	}

    /**
     * Finds and displays a team entity.
     *
     */
    public function showAction(Team $team)
    {
        $deleteForm = $this->createDeleteForm($team);

        return $this->render('QuidditchBundle:team:show.html.twig', array(
            'team' => $team,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing team entity.
     *
     */
    public function editAction(Request $request, Team $team)
    {
		$em = $this->getDoctrine()->getManager();
        $deleteForm = $this->createDeleteForm($team);
        $editForm = $this->createTeamForm($team);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
        	echo "Trying to validate the form!";
			if ($this->validateTeamForm($editForm)) {
				$em->persist($team);
				foreach ($team->getPlayers() as $p)
					$em->persist($p);
				$em->flush();
				return $this->redirectToRoute('team_show', array('id' => $team->getId()));
			}
        }

        return $this->render('QuidditchBundle:team:edit.html.twig', array(
            'team' => $team,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a team entity.
     *
     */
    public function deleteAction(Request $request, Team $team)
    {
        $form = $this->createDeleteForm($team);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($team);
            $em->flush();
        }

        return $this->redirectToRoute('team_index');
    }

    /**
     * Creates a form to delete a team entity.
     *
     * @param Team $team The team entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Team $team)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('team_delete', array('id' => $team->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
