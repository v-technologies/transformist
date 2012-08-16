<?php

if ( !defined( 'TRANSFORMIST_BOOTSTRAPPED' )) {
	require_once dirname( dirname( __FILE__ ))
		. DIRECTORY_SEPARATOR . 'bootstrap.php';
}

define(
	'CONVERTER_COLLECTION_INPUT_FILE',
	TRANSFORMIST_TEST_RESOURCE . 'File' . DS . 'Input' . DS . 'sample.txt'
);

define(
	'CONVERTER_COLLECTION_OUTPUT_FILE',
	TRANSFORMIST_TEST_RESOURCE . 'File' . DS . 'Output' . DS . 'sample.html'
);



/**
 *	Test case for ConverterCollection.
 *
 *	@author Félix Girault <felix@vtech.fr>
 */

class Transformist_ConverterCollectionTest extends PHPUnit_Framework_TestCase {

	/**
	 *
	 */

	public $Collection = null;



	/**
	 *
	 */

	public function setup( ) {

		if ( !Runkit::isEnabled( )) {
			$this->markTestAsSkipped( 'Runkit must be enabled.' );
		}

		Runkit::redefine( 'TRANSFORMIST_ROOT', TRANSFORMIST_TEST_RESOURCE );

		if ( file_exists( CONVERTER_COLLECTION_OUTPUT_FILE )) {
			unlink( CONVERTER_COLLECTION_OUTPUT_FILE );
		}

		$this->Collection = new Transformist_ConverterCollection( );
	}



	/**
	 *
	 */

	public function testAvailableConversions( ) {

		$this->assertEquals(
			array(
				'text/html' => array(
					'application/xml'
				),
				'text/plain' => array(
					'text/html'
				)
			),
			$this->Collection->availableConversions( )
		);
	}



	/**
	 *
	 */

	public function testCanConvert( ) {

		$Document = new Transformist_Document(
			new Transformist_FileInfo( CONVERTER_COLLECTION_INPUT_FILE, 'text/plain' ),
			new Transformist_FileInfo( CONVERTER_COLLECTION_OUTPUT_FILE, 'text/html' )
		);

		$this->assertTrue( $this->Collection->canConvert( $Document ));
	}



	/**
	 *
	 */

	public function testCantConvert( ) {

		$Document = new Transformist_Document(
			new Transformist_FileInfo( 'foo', 'text/plain' ),
			new Transformist_FileInfo( 'bar', 'unknown' )
		);

		$this->assertFalse( $this->Collection->canConvert( $Document ));
	}



	/**
	 *
	 */

	public function testConvert( ) {

		$Document = new Transformist_Document(
			new Transformist_FileInfo( CONVERTER_COLLECTION_INPUT_FILE, 'text/plain' ),
			new Transformist_FileInfo( CONVERTER_COLLECTION_OUTPUT_FILE, 'text/html' )
		);

		$this->Collection->convert( $Document );

		$this->assertTrue( $Document->isConverted( ));
	}



	/**
	 *
	 */

	public function tearDown( ) {

		Runkit::reset( 'TRANSFORMIST_ROOT' );
	}
}
