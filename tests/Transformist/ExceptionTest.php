<?php

if ( !defined( 'TRANSFORMIST_BOOTSTRAPPED' )) {
	require_once dirname( dirname( __FILE__ ))
		. DIRECTORY_SEPARATOR . 'bootstrap.php';
}



/**
 *	Test case for Exception.
 *
 *	@author Félix Girault <felix@vtech.fr>
 */

class Transformist_ExceptionTest extends PHPUnit_Framework_TestCase {

	/**
	 *
	 */

	public function testConstruct( ) {

		$message = 'Hello world!';

		$Exception = new Transformist_Exception( $message );
		$this->assertEquals( $message, $Exception->getMessage( ));
	}



	/**
	 *
	 */

	public function testConstructFormatted( ) {

		$format = 'Hello %s!';
		$argument = 'world';
		$message = sprintf( $format, $argument );

		$Exception = new Transformist_Exception( $format, $argument );
		$this->assertEquals( $message, $Exception->getMessage( ));
	}
}
