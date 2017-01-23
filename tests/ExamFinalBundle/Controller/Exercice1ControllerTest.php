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
    public function testInit()
    {
        $this->assertEquals(true, true);
    }
    public function test1 ()
    {
        $this->assertEquals('wavild', $this->controller->traduire('wild'));
    }
    public function test2 ()
    {
        $this->assertEquals('wavild cavode schavool', $this->controller->traduire('wild code school'));
    }
    public function test3 ()
    {
        $this->assertEquals('avarbre', $this->controller->traduire('arbre'));
    }
    public function test4 ()
    {
        $this->assertEquals('é', $this->controller->traduire('é'));
    }
    public function test5 ()
    {
        $this->assertEquals('bavonjavour avarthavur', $this->controller->traduire('bonjour Arthur'));
    }
    public function test6 ()
    {
        $this->assertEquals('bavonjavour avamélavie', $this->controller->traduire('bonjour Amélie'));
    }
    public function test7 ()
    {
        $this->assertEquals('lavinavux avest bavien mavieux qavue mavicravosavoft', $this->controller->traduire('linux est bien mieux que microsoft'));
    }
    public function test8 ()
    {
        $this->assertEquals('tavu avas savans davoute mavieux à favaire qavue de lavire laves tavests!', $this->controller->traduire('tu as sans doute mieux à faire que de lire les tests!'));
    }
}