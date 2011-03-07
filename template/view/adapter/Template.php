<?php
/**
 * Lithium: the most rad php framework
 *
 * @copyright     Copyright 2010, Union of RAD (http://union-of-rad.org)
 * @license       http://opensource.org/licenses/bsd-license.php The BSD License
 */

namespace li3_twig\template\view\adapter;

use RuntimeException;
use \lithium\core\Libraries;
use \Twig_Environment;
use \Twig_Loader_Filesystem;
use \Twig_Node_Expression_GetAttr;

/**
 * Template class for rendering Twig templates
 *
 * @see http://twig-project.org
 */
abstract class Template extends \Twig_Template {

    /**
     * Override the getAttribute to handle lazy loaded li3 helpers
     */
    protected function getAttribute($object, $item, array $arguments = array(), 
                                    $type = Twig_Node_Expression_GetAttr::TYPE_ANY, 
                                    $noStrictCheck = false, $line = -1) {
        $result = parent::getAttribute($object, $item, $arguments, $type, $noStrictCheck, $line);
        if ($result === null) {
            // Fetch the helper object and return it
            try {
                $result = (is_object($object)) ? $object->helper($item) : null;
            }
            catch (\Exception $e) {
                $result = null;
            }
        }
        return $result;
    }
}

?>
