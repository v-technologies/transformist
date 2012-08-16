<?php

if ( !defined( 'TRANSFORMIST_BOOTSTRAPPED' )) {
	require_once dirname( dirname( __FILE__ ))
		. DIRECTORY_SEPARATOR . 'bootstrap.php';
}

define(
	'CONVERTER_DEEP_COLLECTION_INPUT_FILE',
	TRANSFORMIST_TEST_RESOURCE . 'File' . DS . 'Input' . DS . 'sample.txt'
);

define(
	'CONVERTER_DEEP_COLLECTION_OUTPUT_FILE',
	TRANSFORMIST_TEST_RESOURCE . 'File' . DS . 'Output' . DS . 'sample.xml'
);



/**
 *	Test case for ConverterCollection.
 *
 *	@author Félix Girault <felix@vtech.fr>
 */

class Transformist_ConverterDeepCollectionTest extends PHPUnit_Framework_TestCase {

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

		if ( file_exists( CONVERTER_DEEP_COLLECTION_OUTPUT_FILE )) {
			unlink( CONVERTER_DEEP_COLLECTION_OUTPUT_FILE );
		}

		$this->Collection = new Transformist_ConverterCollection( true );
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
					'text/html',
					'application/xml'
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
			new Transformist_FileInfo( CONVERTER_DEEP_COLLECTION_INPUT_FILE, 'text/plain' ),
			new Transformist_FileInfo( CONVERTER_DEEP_COLLECTION_OUTPUT_FILE, 'application/xml' )
		);

		$this->assertEquals( 2, $this->Collection->canConvert( $Document ));
	}



	/**
	 *
	 */

	public function testConvert( ) {

		$Document = new Transformist_Document(
			new Transformist_FileInfo( CONVERTER_DEEP_COLLECTION_INPUT_FILE, 'text/plain' ),
			new Transformist_FileInfo( CONVERTER_DEEP_COLLECTION_OUTPUT_FILE, 'application/xml' )
		);

		$this->assertTrue( $this->Collection->convert( $Document ));
	}



	/**
	 *
	 */

	public function tearDown( ) {

		Runkit::reset( 'TRANSFORMIST_ROOT' );
	}
}
