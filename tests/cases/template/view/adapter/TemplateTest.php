<?php

namespace li3_twig\tests\cases\template\view\adapter;

use li3_twig\tests\mocks\template\view\adapter\MockTemplate;

use \Twig_Environment;
use \Twig_Loader_Filesystem;

use \li3_twig\template\view\adapter\Template;
use \li3_twig\template\view\adapter\Twig;

use \lithium\template\view\Renderer;

class TemplateTest extends \lithium\test\Unit {

	public function testConstruct() {
		$Loader = new Twig_Loader_Filesystem(array());
		$environment = new Twig_Environment($Loader, array());
        $environment->initRuntime();
        $template = new MockTemplate($environment);
		$this->assertTrue($template instanceof MockTemplate);

		$this->assertEqual("mock.html.twig", $template->getTemplateName());

        $bar = "bar";
        $foo = new \stdClass;
        $foo->bar = $bar;

        $output = $template->render(compact('foo'));
		$this->assertEqual($bar, $output);
	}
}

?>
