<?php

namespace ExamFinalBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AlgoController extends Controller
{
    //////////////////////////////////////
    // Complète les fonctions suivantes //
    //////////////////////////////////////

    // Exercice 1
    public function traduire($string)
    {
		return preg_replace("/([aiouy][aeiouy]*)|e[aeiouy]+|e(?!\s|$)/", "av$0", strtolower($string));
    }

    // Exercice 2
    public function action($input)
    {
		for ($y = 0; $y < count($input); ++$y) {
			for ($x = 0; $x < count($input[$y]); ++$x) {
				if ($this->mustBeReplaced($x, $y, $input))
					$input[$y][$x] = "2";
			}
		}
		return $input;
    }

    private function mustBeReplaced($x, $y, &$input) {
    	if ($y == 0 || $y == count($input) - 1 || $x == 0 ||$x == count($input[$y]) - 1)
    		return false;
    	for ($x1 = $x - 1; $x1 <= $x + 1; ++$x1)
			for ($y1 = $y - 1; $y1 <= $y + 1; ++$y1)
				if ($input[$y1][$x1] != "1" && $input[$y1][$x1] != "2")
					return false;
    	return true;
	}
}