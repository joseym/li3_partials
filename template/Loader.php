<?php
/**
 * Lithium: the most rad php framework
 *
 * @copyright     Copyright 2010, Union of RAD (http://union-of-rad.org)
 * @license       http://opensource.org/licenses/bsd-license.php The BSD License
 */

namespace li3_twig\template;

use \lithium\util\String;
use \lithium\core\Libraries;
use \lithium\core\Object;

/**
 * View adapter for Twig templating. http://twig-project.org
 *
 * @see lithium\template\view\Renderer
 */
class Loader extends Object {

	/**
	 * Returns the template paths.
	 *
	 * @param mixed $type
	 * @param array $options
	 * @return mixed
	 */
	public function template($type, $options = array()) {
		if (!isset($this->_config['paths'][$type])) {
			return null;
		}

		$options['library'] = isset($options['library']) ? $options['library'] : 'app';
		$library = Libraries::get($options['library']);
		$options['library'] = $library['path'];

		return array_map(function ($item) use ($options) {
			return String::insert($item, $options);
		}, (array) $this->_config['paths'][$type]);
	}
}

?>