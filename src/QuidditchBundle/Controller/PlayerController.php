<?php

namespace QuidditchBundle\Controller;

use QuidditchBundle\Entity\Player;
use QuidditchBundle\Entity\Role;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Player controller.
 *
 */
class PlayerController extends Controller
{
	const ITEMS_PER_PAGE = 50;	// Number of players displayed dynamically

	/**
	 * Lists all Player entities from a page.
	 *
	 * @param Request $request
	 * @param int $pageIndex
	 *
	 * @return string
	 */
	public function playersDisplayAction(Request $request, $pageIndex)
	{
		$pageIndex = max(1, $pageIndex);
		$em = $this->getDoctrine()->getManager();
		$players = $em->getRepository('QuidditchBundle:Player')->findByPage($pageIndex);

		foreach ($players as $i => $player) {
			$players[$i]->setName(htmlspecialchars($player->getName()));
		}
		return $this->render('QuidditchBundle:player:playersDisplay.html.twig', array(
			'players' => $players,
		));
	}

	/**
	 * Lists all player entities.
	 *
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function indexAction()
	{
		return $this->render('QuidditchBundle:player:index.html.twig');
	}

	/**
	 * Lists all player entities. (obsolete, replaced by dynamic loading)
	 *
	 * @param int $pageIndex
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
//    public function indexAction($pageIndex)
//    {
//    	$pageIndex = max(1, $pageIndex);
//        $em = $this->getDoctrine()->getManager();
//
//        $players = $em->getRepository('QuidditchBundle:Player')->findByPage($pageIndex);
//        return $this->render('QuidditchBundle:player:index.html.twig', array(
//            'players' => $players,
//			'page' => $pageIndex
//        ));
//    }

    /**
     * Creates a new player entity.
     *
     */
    public function newAction(Request $request)
    {
        $player = new Player();
		$randomUser = json_decode(file_get_contents("https://randomuser.me/api/"))->results[0];
		$player->setName($randomUser->name->first . " " . $randomUser->name->last);
		$form = $this->createForm('QuidditchBundle\Form\PlayerType', $player);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
        	if ($player->getTeam() == $form->get('team')->getData()) {
        		if ($file = $form->get('file')->getData()) {
					$player->uploadPicture($file, $this->getParameter('pictures_directory_absolute'), $this->getParameter('pictures_directory_asset'));
				}
				$em = $this->getDoctrine()->getManager();
				$em->persist($player);
				$em->flush();

				return $this->redirectToRoute('player_index');
			}
			$form->get('team')->addError(new FormError(strval($player) . " couldn't be added to this team!"));
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
			if ($file = $editForm->get('file')->getData()) {
				$player->uploadPicture($file, $this->getParameter('pictures_directory_absolute'), $this->getParameter('pictures_directory_asset'));
			}
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
			if (is_file($oldFile = $this->getParameter('pictures_directory_absolute') . '/' . $player->getPictureFilename())) {
				unlink($oldFile);
			}

            $em = $this->getDoctrine()->getManager();
            $em->remove($player);
            $em->flush();
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
