<?php
/**
 * Lithium: the most rad php framework
 *
 * @copyright     Copyright 2010, Union of RAD (http://union-of-rad.org)
 * @license       http://opensource.org/licenses/bsd-license.php The BSD License
 */

namespace li3_twig\template\view\adapter;

use \lithium\core\Libraries;
use \lithium\core\Environment;
use \Twig_Environment;
use \Twig_Loader_Filesystem;
use \li3_twig\template\view\adapter\Template;

/**
 * View adapter for Twig templating.
 * Using helpers works like in normal li3 templates
 * {{{
 * {{ this.form.create }}
 * {{ this.form.text('title') }}
 * {{ this.form.select('gender', ['m':'male','f':'female']) }}
 * {{ this.form.end }}
 * }}}
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
	public $environment = null;

	/**
	 * Constructor for this adapter - sets relevant default configurations for Twig to be used
	 * when instantiating a new Twig_Environment and Twig_Loader_Filesystem.
	 *
	 * @param array $config Optional configuration directives.
	 *        Please see http://www.twig-project.org/book/03-Twig-for-Developers for all
	 *        available configuration keys and their description.
	 * @return void
	 */
    public function __construct(array $config = array()) {
		$defaults = array(
			'cache' => LITHIUM_APP_PATH . '/resources/tmp/cache/templates',
            'auto_reload' => (!Environment::is('production')),
            'base_template_class' => '\li3_twig\template\view\adapter\Template',
            'autoescape' => false
		);
		parent::__construct($config + $defaults);
	}

	/**
	 * Initialize the necessary Twig objects & attach them to the current object instance.
	 *
	 * @return void
	 */
	public function _init() {
		parent::_init();
		$Loader = new Twig_Loader_Filesystem(array());
		$this->environment = new Twig_Environment($Loader, $this->_config);
	}

	/**
	 * Renders a template
	 *
	 * @param mixed $paths
	 * @param array $data
	 * @param array $options
	 * @return string
	 */
	public function render($paths, $data = array(), array $options = array()) {
		$this->_context = $options['context'] + $this->_context;

		$directories = array_map(function ($item) {
			return dirname($item);
		}, $paths);

		$this->environment->getLoader()->setPaths($directories);

		//Loading template.. Will look in all the paths.
		$template = $this->environment->loadTemplate(basename($paths[0]));

		//Because $this is not availible in the Twig template view is used as a substitute.
		return $template->render((array) $data + array('this' => $this));
	}
}

?>
