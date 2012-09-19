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
 *	Types
 */

Transformist_Registry::register(
	array(
		'avi'	=> 'video/x-msvideo',
		'css'	=> 'text/css',
		'csv'	=> 'text/csv',
		'doc'	=> 'application/msword',
		'flv'	=> 'video/x-flv',
		'gif'	=> 'image/gif',
		'html'	=> 'text/html',
		'ico'	=> 'image/vnd.microsoft.icon',
		'jpg'	=> 'image/jpeg',
		'js'		=> 'application/javascript',
		'js'		=> 'text/javascript',
		'json'	=> 'application/json',
		'mov'	=> 'video/quicktime',
		'mp3'	=> 'audio/mpeg',
		'mp4'	=> 'video/mp4',
		'odg'	=> 'application/vnd.oasis.opendocument.graphics',
		'odp'	=> 'application/vnd.oasis.opendocument.presentation',
		'ods'	=> 'application/vnd.oasis.opendocument.spreadsheet',
		'odt'	=> 'application/vnd.oasis.opendocument.text',
		'ogg'	=> 'application/ogg',
		'pdf'	=> 'application/pdf',
		'pdf'	=> 'application/pdfa',	// not official
		'png'	=> 'image/png',
		'svg'	=> 'image/svg+xml',
		'swf'	=> 'application/x-shockwave-flash',
		'tiff'	=> 'image/tiff',
		'txt'	=> 'text/plain',
		'wav'	=> 'audio/x-wav',
		'wma'	=> 'audio/x-ms-wma',
		'wmv'	=> 'video/x-ms-wmv',
		'xhtml'	=> 'application/xhtml+xml',
		'xml'	=> 'application/xml',
		'xml'	=> 'text/xml',
		'xul'	=> 'application/vnd.mozilla.xul+xml',
		'zip'	=> 'application/zip'
	)
);
