<?php

if ( !defined( 'TRANSFORMIST_BOOTSTRAPPED' )) {
	require_once dirname( dirname( dirname( dirname( __FILE__ ))))
		. DIRECTORY_SEPARATOR . 'bootstrap.php';
}



/**
 *	Test case for PngToTiff.
 *
 *	@author Félix Girault <felix@vtech.fr>
 */

class Transformist_Converter_Office_PngToTiffTest extends PHPUnit_Framework_TestCase {

	/**
	 *
	 */

	public $PngToTiff = null;



	/**
	 *
	 */

	public function setup( ) {

		$this->PngToTiff = new Transformist_Converter_Office_PngToTiff( );
	}



	/**
	 *
	 */

	public function testCanConvert( ) {

		$Document = new Transformist_Document(
			new Transformist_FileInfo( 'foo', 'image/png' ),
			new Transformist_FileInfo( 'bar', 'image/tiff' )
		);

		$this->assertTrue( $this->PngToTiff->canConvert( $Document ));
	}
}
