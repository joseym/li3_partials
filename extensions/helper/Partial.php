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


	protected $_partials = array();

	/**
	 * Calls partials from `_strings`
	 * 
	 * @param  string $method callable name
	 * @param  array  $args   [description]
	 * @return mixed
	 */
	public function __call($method, $args) {

		$_strings = $this->_context->strings();
		$_context = $this->_context->context();
		
		$_strings['Partials']['strings'] = $this->_partials;

		if(!empty($args)){

			if(is_string($args[0]) OR is_bool($args[0])){

				self::_setString($method, $args[0]);

				$_strings['Partials']['strings'] += $this->_partials;

				$this->_context->strings($_strings);

			}

		} else {

			$isString = ((isset($args[0]) AND $args[0]['type'] == 'string') OR empty($args)) ? true : false;
			$isBlock = (!$isString) ? true : false;

			if($isString){
				return (isset($_strings['Partials']['strings'][$method])) ? $_strings['Partials']['strings'][$method] : false;
			} elseif ($isBlock) {
				return (isset($_strings['Partials']['blocks'][$method])) ? $_strings['Partials']['blocks'][$method] : false;
			} else {
				return false;
			}

		}

	}

	private function _setString($method, $value){

		return $this->_partials += array($method => $value);

	}

	public function block($method){
		
		return self::$method(array('type' => 'block'));

	}

	public function string($method){
		
		return self::$method(array('type' => 'string'));

	}

}

?>
