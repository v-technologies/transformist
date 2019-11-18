<?php

if ( !defined( 'TRANSFORMIST_BOOTSTRAPPED' )) {
	require_once dirname( dirname( __FILE__ ))
		. DIRECTORY_SEPARATOR . 'bootstrap.php';
}

use PHPUnit\Framework\TestCase;

/**
 *	Test case for ConverterCollection.
 *
 *	@author Félix Girault <felix@vtech.fr>
 */

class Transformist_ConverterCollectionTest extends TestCase {

	/**
	 *
	 */

	public $ConverterCollection = null;



	/**
	 *
	 */

	public function setUp( ) : void {

		Runkit::requiredBy( $this );
		Runkit::redefineConstant( 'TRANSFORMIST_ROOT', TRANSFORMIST_TEST_RESOURCE );

		$this->ConverterCollection = new Transformist_ConverterCollection( );
	}



	/**
	 *
	 */

	public function testNames( ) {

		$this->assertEquals(
			array(
				'Transformist_Converter_Fake_Html',
				'Transformist_Converter_Fake_Json',
				'Transformist_Converter_Fake_Xml'
			),
			$this->ConverterCollection->names( )
		);
	}



	/**
	 *
	 */

	public function testGet( ) {

		$Converter = $this->ConverterCollection->get( 'Transformist_Converter_Fake_Html' );

		$this->assertTrue( $Converter instanceof Transformist_Converter_Fake_Html );
	}



	/**
	 *
	 */

	public function testGetUnknown( ) {

		$this->assertNull( $this->ConverterCollection->get( 'Unknown' ));
	}



	/**
	 *
	 */

	public function tearDown( ) : void {

		Runkit::resetConstant( 'TRANSFORMIST_ROOT' );
	}
}
