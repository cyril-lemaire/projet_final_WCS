<?php

namespace QuidditchBundle\Controller;

use QuidditchBundle\Entity\Player;
use QuidditchBundle\Entity\Role;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Player controller.
 *
 */
class PlayerController extends Controller
{
	const ITEMS_PER_PAGE = 50;
	/**
	 * Lists all player entities.
	 *
	 * @param int $pageIndex
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
    public function indexAction($pageIndex)
    {
    	$pageIndex = max(1, $pageIndex);
        $em = $this->getDoctrine()->getManager();

        $players = $em->getRepository('QuidditchBundle:Player')->findByPage($pageIndex);
        return $this->render('QuidditchBundle:player:index.html.twig', array(
            'players' => $players,
			'page' => $pageIndex
        ));
    }

    /**
     * Creates a new player entity.
     *
     */
    public function newAction(Request $request)
    {
        $player = new Player();
		$form = $this->createForm('QuidditchBundle\Form\PlayerType', $player);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $player->setTeam($form->get('team')->getData());
            $em->persist($player);
            $em->flush();

            return $this->redirectToRoute('player_index');
        }

        return $this->render('QuidditchBundle:player:new.html.twig', array(
            'player' => $player,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a player entity.
     *
     */
    public function showAction(Player $player)
    {
        $deleteForm = $this->createDeleteForm($player);

        return $this->render('QuidditchBundle:player:show.html.twig', array(
            'player' => $player,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing player entity.
     *
     */
    public function editAction(Request $request, Player $player)
    {
        $deleteForm = $this->createDeleteForm($player);
        $editForm = $this->createForm('QuidditchBundle\Form\PlayerType', $player);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
        	$em = $this->getDoctrine()->getManager();
			$em->persist($player);
			$em->flush();

            return $this->redirectToRoute('player_edit', array('id' => $player->getId()));
        }

        return $this->render('QuidditchBundle:player:edit.html.twig', array(
            'player' => $player,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a player entity.
     *
     */
    public function deleteAction(Request $request, Player $player)
    {
        $form = $this->createDeleteForm($player);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($player);
            $em->flush($player);
        }

        return $this->redirectToRoute('player_index');
    }

    /**
     * Creates a form to delete a player entity.
     *
     * @param Player $player The player entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Player $player)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('player_delete', array('id' => $player->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
