<?php
/**
 * Partials - Partial templates in Lithium.
 *
 * @package       CMS
 * @copyright     Copyright 2012, Josey Morton, (www.mortlabs.com)
 * @license       http://opensource.org/licenses/bsd-license.php The BSD License
 */

namespace li3_partials\extensions\helper;

use lithium\template\TemplateException;
use lithium\template\view\Renderer;

class Partial extends \lithium\template\Helper {

	protected $_strings = array();

	/**
	 * Calls partials from context
	 * 
	 * @param  string $method callable name
	 * @param  array  $args   [description]
	 * @return mixed
	 */
	public function __call($method, $args) {

		$context = $this->_context->context();
		$_strings = $this->_context->strings();
		$strings = isset($_strings['Partials']['strings']) ? $_strings['Partials']['strings'] : false;
		$blocks = isset($_strings['Partials']['blocks']) ? $_strings['Partials']['blocks'] : false;

		if(!empty($args) AND is_string($args[0])){

			self::_setString($method, $args[0]);

		} else {
			
			$isString = ((isset($args[0]) AND $args[0]['type'] == 'string') OR empty($args)) ? true : false;
			$isBlock = (!$isString) ? true : false;

			if($isString){
				return (isset($strings[$method])) ? $strings[$method] : false;
			} elseif ($isBlock) {
				return (isset($blocks[$method])) ? $blocks[$method] : false;
			} else {
				return false;
			}

		}


	}

	private function _setString($method, $value){
		$strings['Partials']['strings'][$method] = $value;
		return $this->_context->strings($strings);

	}

	public function block($method){
		
		return self::$method(array('type' => 'block'));

	}

	public function string($method){
		
		return self::$method(array('type' => 'string'));

	}

}

?>
