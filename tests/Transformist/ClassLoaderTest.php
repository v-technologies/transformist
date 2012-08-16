<?php

if ( !defined( 'TRANSFORMIST_BOOTSTRAPPED' )) {
	require_once dirname( dirname( __FILE__ ))
		. DIRECTORY_SEPARATOR . 'bootstrap.php';
}



/**
 *	Test case for ClassLoader.
 *
 *	@author Félix Girault <felix@vtech.fr>
 */

class Transformist_ClassLoaderTest extends PHPUnit_Framework_TestCase {

	/**
	 *
	 */

	public $ClassLoader = null;



	/**
	 *
	 */

	public function setUp( ) {

		$this->ClassLoader = new Transformist_ClassLoader( TRANSFORMIST_TEST_RESOURCE );
		$this->ClassLoader->register( );
	}



	/**
	 *
	 */

	public function testRegister( ) {

		$this->assertTrue(
			in_array(
				array( $this->ClassLoader, 'load' ),
				spl_autoload_functions( )
			)
		);
	}



	/**
	 *
	 */

	public function testLoad( ) {

		$this->assertTrue( class_exists( 'Transformist_Converter_TextToHtml' ));
		$this->assertTrue( class_exists( 'Transformist_Converter_HtmlToXml_HtmlToXmlFoo' ));
	}



	/**
	 *
	 */

	public function testLoadUndefined( ) {

		$this->assertFalse( class_exists( 'Transformist_Converter_Undefined' ));
	}
}
