<?php
/**
 * Lithium: the most rad php framework
 *
 * @copyright     Copyright 2010, Union of RAD (http://union-of-rad.org)
 * @license       http://opensource.org/licenses/bsd-license.php The BSD License
 */
 
lithium\net\http\Media::type('default', null, array(
    'view' => '\lithium\template\View',
    'loader' => 'li3_twig\template\Loader',
    'renderer' => 'li3_twig\template\view\adapter\Twig',
    'paths' => array(
        'template' => '{:library}/views/{:controller}/{:template}.{:type}',
        'layout'   => '{:library}/views/layouts/{:layout}.{:type}',
    ),
));