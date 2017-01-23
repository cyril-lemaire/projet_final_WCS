<?php

namespace ExamFinalBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('@ExamFinal/default/index.html.twig');
    }

    public function algoAction()
    {
        return $this->render('ExamFinalBundle:Algorithmique:index.html.twig');
    }

    public function sf2Action()
    {
        return $this->render('@ExamFinal/SF2/index.html.twig');
    }
}
