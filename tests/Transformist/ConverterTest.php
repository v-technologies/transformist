<?php

if ( !defined( 'TRANSFORMIST_BOOTSTRAPPED' )) {
	require_once dirname( dirname( __FILE__ ))
		. DIRECTORY_SEPARATOR . 'bootstrap.php';
}

define( 'CONVERTER_INPUT_TYPE', 'application/xml' );
define( 'CONVERTER_OUTPUT_TYPE', 'application/pdf' );



/**
 *	Test case for Converter.
 *
 *	@author Félix Girault <felix@vtech.fr>
 */

class Transformist_ConverterTest extends PHPUnit_Framework_TestCase {

	/**
	 *
	 */

	public $Converter = null;



	/**
	 *
	 */

	public function setUp( ) {

		$this->Converter = new Transformist_ConcreteConverter( );
	}



	/**
	 *
	 */

	public function testCanConvert( ) {

		$Document = new Transformist_Document(
			new Transformist_FileInfo( 'foo', CONVERTER_INPUT_TYPE ),
			new Transformist_FileInfo( 'bar', CONVERTER_OUTPUT_TYPE )
		);

		$this->assertTrue( $this->Converter->canConvert( $Document ));
	}



	/**
	 *
	 */

	public function testCanConvertWithUnknownTypes( ) {

		$OtherDocument = new Transformist_Document(
			new Transformist_FileInfo( 'foo', 'unknown' ),
			new Transformist_FileInfo( 'bar', 'unknown' )
		);

		$this->assertFalse( $this->Converter->canConvert( $OtherDocument ));
	}



	/**
	 *
	 */

	public function testInputType( ) {

		$this->assertEquals( CONVERTER_INPUT_TYPE, $this->Converter->inputType( ));
	}



	/**
	 *
	 */

	public function testOutputType( ) {

		$this->assertEquals( CONVERTER_OUTPUT_TYPE, $this->Converter->outputType( ));
	}
}



/**
 *
 */

class Transformist_ConcreteConverter extends Transformist_Converter {

	/**
	 *
	 */

	protected $_inputType = CONVERTER_INPUT_TYPE;



	/**
	 *
	 */

	protected $_outputType = CONVERTER_OUTPUT_TYPE;



	/**
	 *
	 */

	public function convert( $Document ) { }

}
