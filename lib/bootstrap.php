<?php

/**
 *	Core constants
 */

if ( !defined( 'DS')) {
	define( 'DS', DIRECTORY_SEPARATOR );
}

if ( !defined( 'TRANSFORMIST_ROOT')) {
	define( 'TRANSFORMIST_ROOT', dirname( __FILE__ ) . DS );
}

if ( !defined( 'TRANSFORMIST_BOOTSTRAPPED' )) {
	define( 'TRANSFORMIST_BOOTSTRAPPED', true );
}



/**
 *	Autoload
 */

require_once TRANSFORMIST_ROOT . 'Transformist' . DS . 'ClassLoader.php';

$ClassLoader = new Transformist_ClassLoader( TRANSFORMIST_ROOT );
$ClassLoader->register( );



/**
 *	Utility functions for easy debugging.
 */

function dump( $var ) {

	echo '<pre>';
	var_dump( $var );
	echo '</pre>';
}

function export( $var ) {

	echo '<pre>';
	var_export( $var );
	echo '</pre>';
}
