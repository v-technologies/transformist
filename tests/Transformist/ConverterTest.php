<?php

if ( !defined( 'INCLUDED' )) {
	require_once dirname( dirname( __FILE__ )) . DIRECTORY_SEPARATOR . 'bootstrap.php';
}

define( 'TEST_INPUT_TYPE', 'text/plain' );
define( 'TEST_OUTPUT_TYPE', 'application/pdf' );



/**
 *
 */

class Transformist_ConcreteConverter extends Transformist_Converter {

	/**
	 *
	 */

	protected $_inputType = TEST_INPUT_TYPE;



	/**
	 *
	 */

	protected $_outputType = TEST_OUTPUT_TYPE;



	/**
	 *
	 */

	protected function _convert( $Document ) {

	}
}



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
			new Transformist_FileInfo( 'input.test', TEST_INPUT_TYPE ),
			new Transformist_FileInfo( 'output.test', TEST_OUTPUT_TYPE )
		);

		$this->assertTrue( $this->Converter->canConvert( $Document ));

		$OtherDocument = new Transformist_Document(
			new Transformist_FileInfo( 'input.test', 'unknown' ),
			new Transformist_FileInfo( 'output.test', 'unknown' )
		);

		$this->assertFalse( $this->Converter->canConvert( $OtherDocument ));
	}



	/**
	 *
	 */

	public function testInputType( ) {

		$this->assertEquals( TEST_INPUT_TYPE, $this->Converter->inputType( ));
	}



	/**
	 *
	 */

	public function testOutputType( ) {

		$this->assertEquals( TEST_OUTPUT_TYPE, $this->Converter->outputType( ));
	}



	/**
	 *
	 */

	public function testConvert( ) {


	}
}
