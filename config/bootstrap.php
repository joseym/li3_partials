<?php

use \lithium\core\Libraries;

/**
 * This is the path to the li3_twig plugin, used for Libraries path resolution.
 */
define('LI3_TWIG_PATH', dirname(__DIR__));


/**
 * Add the Twig libraries
 */
Libraries::add('Twig', array(
	'path' => LI3_TWIG_PATH . '/libraries/Twig/lib/Twig',
	'prefix' => 'Twig_',
	'loader' => 'Twig_Autoloader::autoload',
));

?>