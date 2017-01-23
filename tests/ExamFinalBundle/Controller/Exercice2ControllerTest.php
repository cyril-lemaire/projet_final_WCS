<?php

namespace ExamFinalBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use ExamFinalBundle\Controller\AlgoController;

class Exercice1ControllerTest extends WebTestCase
{
    private $controller;

    public function __construct()
    {
        $this->controller = new AlgoController();
    }

    public $input55 = array (
        array(1, 1, 1, 1, 1),
        array(1, 1, 1, 1, 1),
        array(1, 1, 1, 1, 1),
        array(1, 1, 1, 1, 1),
        array(1, 1, 1, 1, 1),
        array(1, 1, 1, 1, 1),
    );

    public $output55 = array (
        array(1, 1, 1, 1, 1),
        array(1, 2, 2, 2, 1),
        array(1, 2, 2, 2, 1),
        array(1, 2, 2, 2, 1),
        array(1, 2, 2, 2, 1),
        array(1, 1, 1, 1, 1),
    );

    public $input35 = array (
        array(1, 1, 1),
        array(1, 1, 1),
        array(1, 1, 1),
        array(1, 1, 1),
        array(1, 1, 1),
        array(1, 1, 1),
    );

    public $output35 = array (
        array(1, 1, 1),
        array(1, 2, 1),
        array(1, 2, 1),
        array(1, 2, 1),
        array(1, 2, 1),
        array(1, 1, 1),
    );

    public $inputL = array (
        array(1, 1, 1, 1, 0, 0, 0, 0, 0),
        array(1, 1, 1, 1, 0, 0, 0, 0, 0),
        array(1, 1, 1, 1, 0, 0, 0, 0, 0),
        array(1, 1, 1, 1, 0, 0, 0, 0, 0),
        array(1, 1, 1, 1, 0, 0, 0, 0, 0),
        array(1, 1, 1, 1, 1, 1, 1, 1, 1),
        array(1, 1, 1, 1, 1, 1, 1, 1, 1),
        array(1, 1, 1, 1, 1, 1, 1, 1, 1),
        array(1, 1, 1, 1, 1, 1, 1, 1, 1),
    );

    public $outputL = array (
        array(1, 1, 1, 1, 0, 0, 0, 0, 0),
        array(1, 2, 2, 1, 0, 0, 0, 0, 0),
        array(1, 2, 2, 1, 0, 0, 0, 0, 0),
        array(1, 2, 2, 1, 0, 0, 0, 0, 0),
        array(1, 2, 2, 1, 0, 0, 0, 0, 0),
        array(1, 2, 2, 1, 1, 1, 1, 1, 1),
        array(1, 2, 2, 2, 2, 2, 2, 2, 1),
        array(1, 2, 2, 2, 2, 2, 2, 2, 1),
        array(1, 1, 1, 1, 1, 1, 1, 1, 1),
    );
    public $inputCross = array (
        array(0, 0, 0, 1, 1, 1, 0, 0, 0),
        array(0, 0, 0, 1, 1, 1, 0, 0, 0),
        array(0, 0, 0, 1, 1, 1, 0, 0, 0),
        array(1, 1, 1, 1, 1, 1, 1, 1, 1),
        array(1, 1, 1, 1, 1, 1, 1, 1, 1),
        array(1, 1, 1, 1, 1, 1, 1, 1, 1),
        array(0, 0, 0, 1, 1, 1, 0, 0, 0),
        array(0, 0, 0, 1, 1, 1, 0, 0, 0),
        array(0, 0, 0, 1, 1, 1, 0, 0, 0),
    );
    public $outputCross = array (
        array(0, 0, 0, 1, 1, 1, 0, 0, 0),
        array(0, 0, 0, 1, 2, 1, 0, 0, 0),
        array(0, 0, 0, 1, 2, 1, 0, 0, 0),
        array(1, 1, 1, 1, 2, 1, 1, 1, 1),
        array(1, 2, 2, 2, 2, 2, 2, 2, 1),
        array(1, 1, 1, 1, 2, 1, 1, 1, 1),
        array(0, 0, 0, 1, 2, 1, 0, 0, 0),
        array(0, 0, 0, 1, 2, 1, 0, 0, 0),
        array(0, 0, 0, 1, 1, 1, 0, 0, 0),
    );

    public function testInit()
    {
        $this->assertEquals(true, true);
    }
    public function test1 ()
    {
        $this->assertEquals($this->output55,  $this->controller->action($this->input55));
    }
    public function test2 ()
    {
        $this->assertEquals($this->output35,  $this->controller->action($this->input35));
    }
    public function test3 ()
    {
        $this->assertEquals($this->outputL,  $this->controller->action($this->inputL));
    }
    public function test4 ()
    {
        $this->assertEquals($this->outputCross,  $this->controller->action($this->inputCross));
    }
}