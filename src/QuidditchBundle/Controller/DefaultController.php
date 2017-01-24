<?php

namespace QuidditchBundle\Controller;

use QuidditchBundle\Entity\Team;
use QuidditchBundle\Form\TeamType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('QuidditchBundle:Default:index.html.twig');
    }
}
