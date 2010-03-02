<?php
/**
 * Lithium: the most rad php framework
 *
 * @copyright     Copyright 2010, Union of RAD (http://union-of-rad.org)
 * @license       http://opensource.org/licenses/bsd-license.php The BSD License
 */

namespace li3_twig\template\view\adapter;

use \lithium\util\String;
use \lithium\template\view\Renderer;
use \lithium\core\Libraries;

/**
 * View adapter for Twig templating. http://twig-project.org
 *
 * @see lithium\template\view\Renderer
 */

class Twig extends Renderer
{
    /**
     * @var Twig_Environment
     */
    public $_environment = null;
    
    /**
     * Sets up the necesarry libraries and autoloaders for this view adapter
     *
     * @param array $config
     * @return void
     */
    public function __construct($config = array())
    {
        parent::__construct($config);
        
        Libraries::add('Twig', array(
            'path' => realpath(__DIR__ . '/../../../libraries/Twig/lib/Twig'),
            'prefix' => 'Twig_',
            'loader' => 'Twig_Autoloader::autoload',
        ));
        
        $this->_environment = new \Twig_Environment(new \Twig_Loader_Filesystem(array()), array(
            'cache' => LITHIUM_APP_PATH . '/resources/tmp/cache/templates',
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
    public function render($paths, $data = array(), $options = array())
    {
        $directories = array_map(function ($item) {
            return dirname($item);
        }, $paths);
        
        $this->_environment->getLoader()->setPaths($directories);
    
        //Loading template.. Will look in all the paths.
        $template = $this->_environment->loadTemplate(basename($paths[0]));
           
        //Because $this is not availible in the Twig template view is used as
        //an substitute.
        return $template->render((array) $data + array('view' => $this));
    }
}