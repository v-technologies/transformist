<?php

if ( !defined( 'TRANSFORMIST_BOOTSTRAPPED' )) {
	require_once dirname( dirname( __FILE__ ))
		. DIRECTORY_SEPARATOR . 'bootstrap.php';
}



/**
 *	Test case for ConverterCollection.
 *
 *	@author Félix Girault <felix@vtech.fr>
 */

class Transformist_ConverterCollectionTest extends PHPUnit_Framework_TestCase {

	/**
	 *
	 */

	public $ConverterCollection = null;



	/**
	 *
	 */

	public function setUp( ) {

		if ( !Runkit::isEnabled( )) {
			$this->markTestSkipped( 'Runkit must be enabled.' );
		}

		Runkit::redefineConstant( 'TRANSFORMIST_ROOT', TRANSFORMIST_TEST_RESOURCE );

		$this->ConverterCollection = new Transformist_ConverterCollection( );
	}



	/**
	 *
	 */

	public function testConverterNames( ) {

		$this->assertEquals(
			array(
				'Transformist_Converter_Html',
				'Transformist_Converter_Json',
				'Transformist_Converter_Xml_XmlFoo'
			),
			$this->ConverterCollection->converterNames( )
		);
	}



	/**
	 *
	 */

	public function testConverter( ) {

		$Converter = $this->ConverterCollection->converter( 'Transformist_Converter_Html' );

		$this->assertTrue( $Converter instanceof Transformist_Converter_Html );
	}



	/**
	 *
	 */

	public function testUnknownConverter( ) {

		$this->assertNull( $this->ConverterCollection->converter( 'Unknown' ));
	}



	/**
	 *
	 */

	public function tearDown( ) {

		Runkit::resetConstant( 'TRANSFORMIST_ROOT' );
	}
}
