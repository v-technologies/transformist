<?php

if ( !defined( 'TRANSFORMIST_BOOTSTRAPPED' )) {
	require_once dirname( dirname( __FILE__ ))
		. DIRECTORY_SEPARATOR . 'bootstrap.php';
}



/**
 *	Test case for Transformist.
 *
 *	@author Félix Girault <felix@vtech.fr>
 */

class Transformist_TransformistTest extends PHPUnit_Framework_TestCase {

	/**
	 *
	 */

	public $ConverterCollection = null;



	/**
	 *
	 */

	public function setUp( ) {

		$this->ConverterCollection = new Transformist_ConverterCollection( );
	}



	/**
	 *
	 */

	public function testAvailableConversions( ) {

		$this->assertEquals(
			$this->ConverterCollection->availableConversions( ),
			Transformist_Transformist::availableConversions( )
		);
	}



	/**
	 *
	 */

	public function testConvert( ) {

		$Document = new Transformist_Document(
			new Transformist_FileInfo( 'input.txt', 'text/plain' ),
			new Transformist_FileInfo( 'output.doc', 'application/msword' )
		);

		$this->assertEquals(
			$this->ConverterCollection->convert( $Document ),
			Transformist_Transformist::convert( $Document )
		);
	}
}
