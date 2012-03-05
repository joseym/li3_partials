<?php
/**
 * Lithium: the most rad php framework
 *
 * @copyright     Copyright 2010, Union of RAD (http://union-of-rad.org)
 * @license       http://opensource.org/licenses/bsd-license.php The BSD License
 */

namespace li3_partials\template\view\adapter;

use lithium\template\Helper;
use \lithium\core\Libraries;
use \lithium\core\Environment;
use lithium\util\String;
use lithium\template\TemplateException;

// class Parser extends \lithium\template\view\Renderer {
class Parser extends \lithium\template\view\adapter\File {

	protected $_blocks = array();

	protected static $_viewContent;

	/**
	 * Parses the template for block partials and adds them to the core `_strings` array.
	 * Everything contained within the `<partial />` tag will be added to the context
	 * 
	 * {{{
	 * 	<partial name="sidebar"><h2>Sidebar for this view!</h2></partial>
	 * }}}
	 *
	 * @see lithium\template\view\adapter\File::render()
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
		$template__ = (is_array($template)) ? $template[0] : $template;
		$flipped_path = array_reverse(explode("/", $template__));
		unset($options, $template, $defaults, $data);

		if ($this->_config['extract']) {
			extract($this->_data, EXTR_OVERWRITE);
		} elseif ($this->_view) {
			extract((array) $this->_view->outputFilters, EXTR_OVERWRITE);
		}
		
		ob_start();
		include $template__;
		$content = ob_get_clean();

		// Exclude layouts and elements for now
		// we will only look for partial blocks from views
		if(!preg_match('/layouts/', $flipped_path[0]) AND !preg_match('/elements/', $flipped_path[0])){

			// Look for a partial block
			$pattern = "/<(partial) name=\"([a-zA-Z 0-9]+)\">(.*)<\/\\1>/msU";

			if(preg_match_all( $pattern, $content, $matches )){
				
				$content = preg_replace($pattern, '', $content);

				foreach($matches[2] as $index => $name){
					$this->_blocks += array($name => $matches[3][$index]);
				}

	
			}

			$this->content($content);

		}

		// assign to context
		$this->_strings['Partials']['blocks'] = $this->_blocks;
				
		return $content;

	}

}

?>
