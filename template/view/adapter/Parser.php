<?php
/**
 * Lithium: the most rad php framework
 *
 * @copyright     Copyright 2010, Union of RAD (http://union-of-rad.org)
 * @license       http://opensource.org/licenses/bsd-license.php The BSD License
 */

namespace li3_partials\template\view\adapter;

use \lithium\core\Libraries;
use \lithium\core\Environment;

// class Parser extends \lithium\template\view\Renderer {
class Parser extends \lithium\template\view\adapter\File {

	/**
	 * 
	 *
	 * @param array $config Optional configuration directives.
	 *        Please see http://www.twig-project.org/book/03-Twig-for-Developers for all
	 *        available configuration keys and their description.
	 * @return void
	 */
    public function __construct(array $config = array()) {
		$defaults = array(
			'cache' => LITHIUM_APP_PATH . '/resources/tmp/cache/templates',
            'autoescape' => false
		);
		parent::__construct($config + $defaults);
	}

	/**
	 * 
	 *
	 * @return void
	 */
	public function _init() {

		parent::_init();
	}

	/**
	 * Renders content from a template file provided by `template()`.
	 *
	 * @param string $template
	 * @param array|string $data
	 * @param array $options
	 * @return string
	 */
	public function render($template, $data = array(), array $options = array()) {

		$defaults = array('context' => array());
		$options += $defaults;
		$this->_context += $options['context'];
		$this->_data = (array) $data + $this->_vars;
		$template__ = $template[0];
		unset($options, $template, $defaults, $data);

		if ($this->_config['extract']) {
			extract($this->_data, EXTR_OVERWRITE);
		} elseif ($this->_view) {
			extract((array) $this->_view->outputFilters, EXTR_OVERWRITE);
		}

		ob_start();
		include $template__;
		$content = ob_get_clean();

		if((array_pop(explode("/", $template__)) != 'layout') AND preg_match( "/<(partial) name=\"([a-zA-Z 0-9]+)\">(.*)<\/\\1>/", $content, $matches )){

			// strip out the thing
			$content = str_replace($matches[0], "", $content);

			// assign to context
			$this->_context['Partials']['blocks'][$matches[2]] = $matches[3];
		}

		$this->content($content);
		return $content;

	}

	/**
	 * Currently useless method that is intended to write the results of a 
	 * template containing a partial to cache so it doesn't have to parse it 
	 * every time it loads.
	 * 
	 * @param  string $contents blob of markup to be stored
	 * @param  array  $params
	 * @return string
	 */
	private function _storeCache($contents, array $params = array()){

		$filename = basename($file);

		// get the parsed path, removing the timestamp and size
		$filename = implode("_", array_splice(explode("_", $filename), 0, 2));

		// loop thru files in cache and delete old cache file
		if ($handle = opendir(LITHIUM_APP_PATH . '/resources/tmp/cache/templates')) {

			while (false !== ($oldfile = readdir($handle))) {

				if(preg_match("/{$filename}/", $oldfile)){

				unlink(CACHE_DIR . DS . $oldfile);

				}

			}

			closedir($handle);

		}

		// Store cache file and serve the output to the browser
		file_put_contents($file, $contents);

		return $contents;

	}



}

?>
