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
use lithium\util\String;
use lithium\template\TemplateException;

// class Parser extends \lithium\template\view\Renderer {
class Parser extends \lithium\template\view\adapter\File {


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
		if(($flipped_path[1] != 'layouts') AND ($flipped_path[1] != 'elements')){

			// Look for a partial block
			if(preg_match( "/<(partial) name=\"([a-zA-Z 0-9]+)\">(.*)<\/\\1>/", $content, $matches )){
				
				$content = str_replace($matches[0], "", $content);

				// assign to context
				$this->_context['Partials']['blocks'][$matches[2]] = $matches[3];

			}

			$this->content($content);

		}

		return $content;
	}

}

?>
