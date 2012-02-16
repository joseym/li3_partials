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

class Parser extends \lithium\template\view\Renderer {

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
	 * Renders a template
	 *
	 * @param mixed $paths
	 * @param array $data
	 * @param array $options
	 * @return string
	 */
	public function render($paths, $data = array(), array $options = array()) {

		$stats = stat($paths[0]);

		$cache_name = 'template_' . basename(implode('_', array_slice(explode('/', $paths[0]), 3)), '.php') . "_{$stats['ino']}_{$stats['mtime']}_{$stats['size']}.php";

		$this->_context += $options['context'];

		$directories = array_map(function ($item) {
			return dirname($item);
		}, $paths);

		ob_start();

		// load the template
		include $paths[0];

		// Store template contents
		$contents = ob_get_clean();

		// Catch template blocks
		if((array_pop(explode("/", $directories[0])) != 'layout') AND preg_match( "/<(partial) name=\"([a-zA-Z 0-9]+)\">(.*)<\/\\1>/", $contents, $matches )){

			// strip out the thing
			$contents = str_replace($matches[0], "", $contents);

			// assign to context
			$this->_context['Partials']['blocks'][$matches[2]] = $matches[3];

			// Assign the cleaned view to the content context
			$this->content($contents);

		}

		return $contents;

	}

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
