<?php

/**
 *	Core constants
 */

if ( !defined( 'DS')) {
	define( 'DS', DIRECTORY_SEPARATOR );
}

if ( !defined( 'TRANSFORMIST_TEST_ROOT')) {
	define( 'TRANSFORMIST_TEST_ROOT', dirname( __FILE__ ) . DS );
}



/**
 *	Loads Transformist boostrap.
 */

require_once( dirname( dirname( __FILE__ )) . DS . 'lib' . DS . 'bootstrap.php' );



/**
 *	Autoload
 */

$ClassLoader = new Transformist_ClassLoader( TRANSFORMIST_TEST_ROOT );
$ClassLoader->register( );
