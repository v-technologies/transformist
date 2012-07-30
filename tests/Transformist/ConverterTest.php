<?php

/**
 *	Test case for Converter.
 */

class Transformist_ConverterTest extends PHPUnit_Framework_TestCase {

	/**
	 *
	 */

	public function testConstruct( ) {

		$Converter = new Transformist_Converter( );
		$this->assertTrue( $Converter instanceof Transformist_Converter );

		$Converter = new Transformist_Converter( '' );
	}
}