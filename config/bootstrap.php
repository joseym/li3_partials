<?php
use \lithium\core\Libraries;
use \lithium\net\http\Media;

/**
 * This is the path to the CMS plugin, used for Libraries path resolution.
 */
define('CMS_PATH', dirname(__DIR__));

/**
 * Give CMS access to the media types.
 */
Media::type('default', null, array(
	'view' => '\lithium\template\View',
	'renderer' => '\li3_partials\template\view\adapter\Parser',
	'paths' => array(
		'template' => array(
			'{:library}/views/{:controller}/{:template}.{:type}.php',
			LITHIUM_APP_PATH . '/views/{:controller}/{:template}.{:type}.php'
		),
		'layout' => '{:library}/views/layouts/{:layout}.{:type}.php'
	)
));

?>