<?php

namespace li3_twig\tests\cases\template\view\adapter;

use \li3_twig\template\view\adapter\Twig;
use \lithium\template\view\Renderer;
use \Twig_Environment;

class TwigTest extends \lithium\test\Unit {

	public function testConstruct() {
		$result = new Twig();
		$this->assertTrue($result instanceof Twig);
		$this->assertTrue($result->environment instanceof Twig_Environment);
	}
}

?>