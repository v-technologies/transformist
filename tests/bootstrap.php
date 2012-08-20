<?php

/**
 *	Core constants
 */

if ( !defined( 'DS')) {
	define( 'DS', DIRECTORY_SEPARATOR );
}

if ( !defined( 'TRANSFORMIST_TEST_ROOT' )) {
	define( 'TRANSFORMIST_TEST_ROOT', dirname( __FILE__ ) . DS );
}

if ( !defined( 'TRANSFORMIST_TEST_RESOURCE' )) {
	define( 'TRANSFORMIST_TEST_RESOURCE', TRANSFORMIST_TEST_ROOT . 'Resource' . DS );
}



/**
 *	Loads Transformist boostrap.
 */

require_once dirname( dirname( __FILE__ )) . DS . 'lib' . DS . 'bootstrap.php';



/**
 *	Autoload
 */

$ClassLoader = new Transformist_ClassLoader( TRANSFORMIST_TEST_ROOT );
$ClassLoader->register( );

// Composer

require_once dirname( dirname( __FILE__ )) . DS . 'vendor' . DS . 'autoload.php';



/**
 *	Utility
 */

function Transformist_cleanDirectory( $path ) {

	if ( is_dir( $path )) {
		foreach( glob( $path . DS . '*' ) as $entry ) {
			unlink( $entry );
		}
	} else {
		mkdir( $path );
	}
}
