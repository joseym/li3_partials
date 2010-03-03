<?php
/**
 * Lithium: the most rad php framework
 *
 * @copyright     Copyright 2010, Union of RAD (http://union-of-rad.org)
 * @license       http://opensource.org/licenses/bsd-license.php The BSD License
 */

namespace li3_twig\template\view\adapter;

use \lithium\core\Libraries;
use \Twig_Environment;
use \Twig_Loader_Filesystem;

/**
 * View adapter for Twig templating.
 *
 * @see http://twig-project.org
 * @see lithium\template\view\Renderer
 */
class Twig extends \lithium\template\view\Renderer {

	/**
	 * The Twig Environment object.
	 *
	 * @var object
	 */
	protected $_environment = null;

	/**
	 * Sets up the necesarry libraries and autoloaders for this view adapter.
	 *
	 * @param array $config
	 * @return void
	 */
    public function __construct($config = array()) {
		$config += array('cache' => null, 'debug' => true, 'auto_reloader' => true);
		parent::__construct($config);

		Libraries::add('Twig', array(
			'path' => realpath(__DIR__ . '/../../../libraries/Twig/lib/Twig'),
			'prefix' => 'Twig_',
			'loader' => 'Twig_Autoloader::autoload',
		));

		$this->_environment = new Twig_Environment(new Twig_Loader_Filesystem(array()), array(
			'cache' => null,//LITHIUM_APP_PATH . '/resources/tmp/cache/templates',
			'debug' => true,
			'auto_reloader' => true,
		));
	}

	/**
	 * Renders a template
	 *
	 * @param mixed $paths
	 * @param array $data
	 * @param array $options
	 * @return string
	 */
	public function render($paths, $data = array(), $options = array()) {
		$this->_context = $options['context'] + $this->_context;

		$directories = array_map(function ($item) {
			return dirname($item);
		}, $paths);

		$this->_environment->getLoader()->setPaths($directories);

		//Loading template.. Will look in all the paths.
		$template = $this->_environment->loadTemplate(basename($paths[0]));

		//Because $this is not availible in the Twig template view is used as
		//an substitute.
		return $template->render((array) $data + array('this' => $this));
	}
}

?>