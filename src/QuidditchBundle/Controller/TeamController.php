<?php

namespace QuidditchBundle\Controller;

use QuidditchBundle\Entity\Team;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;

/**
 * Team controller.
 *
 */
class TeamController extends Controller
{
	private function createTeamForm(Team $team) {
		$em = $this->getDoctrine()->getManager();
		$roles = $em->getRepository('QuidditchBundle:Player')->findAllMappedByRole();
		$form = $this->createForm('QuidditchBundle\Form\TeamType', $team);
		$playerIndex = 0;
		foreach (array_keys(Team::MAX_PER_ROLE) as $roleName) {
			$role = $em->getRepository('QuidditchBundle:Role')->findOneByName($roleName);
			$teamPlayers = $team->getPlayers($role);

			for ($i = 0; $i < Team::MAX_PER_ROLE[$roleName]; ++$i) {
				$label = $role . (Team::MAX_PER_ROLE[$roleName] > 1 ? ' ' . strval($i + 1) : '');
				$form->add('player' . $playerIndex++, EntityType::class, array(
					'label' => $label,
					'class' => 'QuidditchBundle:Player',
					'choices' => $roles[$roleName],
					'data' => $teamPlayers[$i],
					'mapped' => false,
				));
			}
		}
		return $form;
	}

	private function validateTeamForm(&$form) {
		$players = [];
		for ($i = 0; $i < array_sum(Team::MAX_PER_ROLE); ++$i) {
			$field = 'player' . $i;
			$player = $form->get($field)->getData();
			if (in_array($player, $players)) {
				$isFormValid = false;
				$form->get($field)->addError(new FormError('You cannot add this player in the team twice!'));
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

        return $this->render('team/index.html.twig', array(
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

        return $this->render('team/new.html.twig', array(
            'team' => $team,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a team entity.
     *
     */
    public function showAction(Team $team)
    {
        $deleteForm = $this->createDeleteForm($team);

        return $this->render('team/show.html.twig', array(
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

        return $this->render('team/edit.html.twig', array(
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
