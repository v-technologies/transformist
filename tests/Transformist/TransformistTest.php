<?php

if ( !defined( 'INCLUDED' )) {
	require_once dirname( dirname( __FILE__ )) . DIRECTORY_SEPARATOR . 'bootstrap.php';
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
			Transformist_Transformist::availableConversions( ),
			$this->ConverterCollection->availableConversions( )
		);
	}



	/**
	 *
	 */

	public function testConvert( ) {

	}
}
