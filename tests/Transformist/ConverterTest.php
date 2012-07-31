<?php

require_once( dirname( dirname( __FILE__ )) . DIRECTORY_SEPARATOR . 'bootstrap.php' );



/**
 *	Test case for Converter.
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

		$this->Converter = new Transformist_Converter( );
	}



	/**
	 *
	 */

	public function testConvertsFrom( ) {

		// default implementation should always return false.

		$this->assertFalse( $this->Converter->convertsFrom( '' ));
	}



	/**
	 *
	 */

	public function testConvertsTo( ) {

		// default implementation should always return false.

		$this->assertFalse( $this->Converter->convertsTo( '' ));
	}



	/**
	 *
	 */

	public function testConvert( ) {

		// default implementation should always return false.

		$this->assertFalse( $this->Converter->convert( '' ));
	}
}
