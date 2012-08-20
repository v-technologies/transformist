<?php

if ( !defined( 'TRANSFORMIST_BOOTSTRAPPED' )) {
	require_once dirname( dirname( dirname( dirname( __FILE__ ))))
		. DIRECTORY_SEPARATOR . 'bootstrap.php';
}



/**
 *	Test case for Png.
 *
 *	@author Félix Girault <felix@vtech.fr>
 */

class Transformist_Converter_Office_PngTest extends PHPUnit_Framework_TestCase {

	/**
	 *
	 */

	public $Png = null;



	/**
	 *
	 */

	public function setup( ) {

		$this->Png = new Transformist_Converter_Office_Png( );
	}



	/**
	 *
	 */

	public function testCanConvert( ) {

		$Document = new Transformist_Document(
			new Transformist_FileInfo( 'foo', 'image/jpeg' ),
			new Transformist_FileInfo( 'bar', 'image/png' )
		);

		$this->assertTrue( $this->Png->canConvert( $Document ));
	}
}
