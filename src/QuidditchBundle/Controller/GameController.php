<?php

namespace QuidditchBundle\Controller;

use QuidditchBundle\Entity\Game;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Game controller.
 * On a un formulaire dans lequel on peut sélectionner deux équipes
 * Après validation, sur la vue suivante:
 * Renvoyer les statistiques globales des deux équipes (expérience total, moyenne d’âge, fatigue moyenne)
 */
class GameController extends Controller
{
	/**
	 * Creates a new game entity.
	 *
	 */
	public function newAction(Request $request)
	{
		$game = new Game();
		$form = $this->createForm('QuidditchBundle\Form\GameType', $game);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid() && count($game->getTeams()) == 2) {
			$em = $this->getDoctrine()->getManager();
			$game->play();
			$em->persist($game);
			$em->flush();

			return $this->redirectToRoute('game_show', array('id' => $game->getId()));
		}

		return $this->render('game/new.html.twig', array(
			'game' => $game,
			'form' => $form->createView(),
		));
	}

	/**
	 * Plays and displays the result of a game entity.
	 *
	 */
	public function showAction(Game $game)
	{
		return $this->render('game/show.html.twig', array(
			'game' => $game,
		));
	}

    /**
     * Lists all game entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $games = $em->getRepository('QuidditchBundle:Game')->findAll();

        return $this->render('game/index.html.twig', array(
            'games' => $games,
        ));
    }

    /**
     * Displays a form to edit an existing game entity.
     *
     */
    public function editAction(Request $request, Game $game)
    {
        $deleteForm = $this->createDeleteForm($game);
        $editForm = $this->createForm('QuidditchBundle\Form\GameType', $game);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('game_edit', array('id' => $game->getId()));
        }

        return $this->render('game/edit.html.twig', array(
            'game' => $game,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a game entity.
     *
     */
    public function deleteAction(Request $request, Game $game)
    {
        $form = $this->createDeleteForm($game);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($game);
            $em->flush($game);
        }

        return $this->redirectToRoute('game_index');
    }

    /**
     * Creates a form to delete a game entity.
     *
     * @param Game $game The game entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Game $game)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('game_delete', array('id' => $game->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
