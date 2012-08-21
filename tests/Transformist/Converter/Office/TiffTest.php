<?php

if ( !defined( 'TRANSFORMIST_BOOTSTRAPPED' )) {
	require_once dirname( dirname( dirname( dirname( __FILE__ ))))
		. DIRECTORY_SEPARATOR . 'bootstrap.php';
}



/**
 *	Test case for Tiff.
 *
 *	@author Félix Girault <felix@vtech.fr>
 */

class Transformist_Converter_Office_TiffTest extends PHPUnit_Framework_TestCase {

	/**
	 *
	 */

	public function testSkip( ) {

		//$this->markTestIncomplete( );
	}



	/**
	 *
	 */

	/*
	public function testCanConvert( ) {

		$Document = new Transformist_Document(
			new Transformist_FileInfo( 'foo', 'image/jpeg' ),
			new Transformist_FileInfo( 'bar', 'image/tiff' )
		);

		$this->assertTrue( Transformist_Converter_Office_Tiff::canConvert( $Document ));
	}
	*/
}
