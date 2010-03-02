<?php
/**
 * Lithium: the most rad php framework
 *
 * @copyright     Copyright 2010, Union of RAD (http://union-of-rad.org)
 * @license       http://opensource.org/licenses/bsd-license.php The BSD License
 */

namespace li3_twig\template\view\adapter;

/**
 * View adapter for Twig templating. http://twig-project.org
 *
 * @see lithium\template\view\Renderer
 */

class Twig extends \lithium\template\view\Renderer
{
    /**
     * @var Twig_Environment
     */
    protected $_environment = null;
    
    /**
     * @var Twig_Loader
     */
    protected $_loader = null;
    
    /**
     * Sets up the necesarry libraries and autoloaders for this view adapter
     *
     * @param array $config
     * @return void
     */
    public function __construct($config = array())
    {
        parent::__construct($config);
        
        \lithium\core\Libraries::add('Twig', array(
            'path' => realpath(__DIR__ . '/../../../libraries/Twig/lib/Twig'),
            'prefix' => 'Twig_',
            'loader' => 'Twig_Autoloader::autoload',
        ));
        
        $this->_loader = new Twig_Loader_Filesystem(array());
        
        $this->_environment = new Twig_Environment($this->_loader, array(
            'cache' => false, //LITHIUM_APP_PATH . '/resources/tmp/cache/templates',
            'auto_reloader' => true,
        ));
    }   
    
    /**
     * Renders a template
     *
     * @param mixed $template
     * @param array $data
     * @param array $options
     * @return string
     */
    public function render($template, $data = array(), $options = array())
    {   
        //Loading template.. Will look in all the paths.
        $template = $this->_environment->loadTemplate($template);
        
        //Because $this is not availible in the Twig template view is used as
        //an substitute.
        return $template->render((array) $data + array('view' => $this));
    }
    
    /**
     * Returns the basename of a template so it can be used with Twig Loader
     * and since the twig loader takes paths we wont do a file_exists on it.
     *
     * @param mixed $type
     * @param array $options
     * @return mixed
     */
    public function template($type, $options = array())
    {
        if (!isset($this->_config['paths'][$type])) {
            return null;    
        }
        
        //maybe need to be reversed to keep the loader priorities.
        $this->_loader->setPaths((array) $this->_config['paths'][$type]);
    }
}