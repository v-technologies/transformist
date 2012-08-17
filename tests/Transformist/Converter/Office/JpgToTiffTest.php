<?php

if ( !defined( 'TRANSFORMIST_BOOTSTRAPPED' )) {
	require_once dirname( dirname( dirname( dirname( __FILE__ ))))
		. DIRECTORY_SEPARATOR . 'bootstrap.php';
}



/**
 *	Test case for JpgToTiff.
 *
 *	@author Félix Girault <felix@vtech.fr>
 */

class Transformist_Converter_Office_JpgToTiffTest extends PHPUnit_Framework_TestCase {

	/**
	 *
	 */

	public $JpgToTiff = null;



	/**
	 *
	 */

	public function setup( ) {

		$this->JpgToTiff = new Transformist_Converter_Office_JpgToTiff( );
	}



	/**
	 *
	 */

	public function testCanConvert( ) {

		$Document = new Transformist_Document(
			new Transformist_FileInfo( 'foo', 'image/jpeg' ),
			new Transformist_FileInfo( 'bar', 'image/tiff' )
		);

		$this->assertTrue( $this->JpgToTiff->canConvert( $Document ));
	}
}
