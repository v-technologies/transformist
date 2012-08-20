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

	public function setUp( ) {

		if ( !Runkit::isEnabled( )) {
			$this->markTestAsSkipped( 'Runkit must be enabled.' );
		}
	}



	/**
	 *
	 */

	public function testAvailableConversions( ) {

		Runkit::reimplementMethod(
			'Transformist_ConverterCollection',
			'availableConversions',
			'',
			'return \'foo\';'
		);

		$this->assertEquals( 'foo', Transformist_Transformist::availableConversions( ));

		Runkit::resetMethod( 'Transformist_ConverterCollection', 'availableConversions' );
	}



	/**
	 *
	 */

	public function testConvert( ) {

		Runkit::reimplementMethod(
			'Transformist_ConverterCollection',
			'convert',
			'$Document',
			'return \'foo\';'
		);

		$this->assertEquals( 'foo', Transformist_Transformist::convert( null ));

		Runkit::resetMethod( 'Transformist_ConverterCollection', 'convert' );
	}
}
