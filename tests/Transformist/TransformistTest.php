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

	public function testConfigure( ) {

		$Collection = $this->getMock( '\\Essence\\ConverterCollection', array( 'enableMultistep' ));
		$Collection->expects( $this->any( ))
			->method( 'enableMultistep' )
			->with( $this->equalTo( true ));

		TestableTransformist::stub( $Collection );
		TestableTransformist::configure( array( 'multistep' => true ));
	}



	/**
	 *
	 */

	public function testTestConverters( ) {

		$Collection = $this->getMock( '\\Essence\\ConverterCollection', array( 'testConverters' ));
		$Collection->expects( $this->any( ))
			->method( 'testConverters' )
			->will( $this->returnValue( array( 'foo' => true )));

		TestableTransformist::stub( $Collection );

		$this->assertEquals(
			array( 'foo' => true ),
			TestableTransformist::testConverters( )
		);
	}



	/**
	 *
	 */

	public function testAvailableConversions( ) {

		$Collection = $this->getMock( '\\Essence\\ConverterCollection', array( 'availableConversions' ));
		$Collection->expects( $this->any( ))
			->method( 'availableConversions' )
			->will( $this->returnValue( array( 'foo' => 'bar' )));

		TestableTransformist::stub( $Collection );

		$this->assertEquals(
			array( 'foo' => 'bar' ),
			TestableTransformist::availableConversions( )
		);
	}



	/**
	 *
	 */

	public function testConvert( ) {

		$Document = new Transformist_Document(
			new Transformist_FileInfo( 'foo', 'application/foo' ),
			new Transformist_FileInfo( 'bar', 'application/bar' )
		);

		$Collection = $this->getMock( '\\Essence\\ConverterCollection', array( 'convert' ));
		$Collection->expects( $this->any( ))
			->method( 'convert' )
			->with( $this->equalTo( $Document ))
			->will( $this->returnValue( true ));

		TestableTransformist::stub( $Collection );

		$this->assertTrue( TestableTransformist::convert( 'foo', 'application/foo' )->to( 'bar', 'application/bar' ));
	}



	/**
	 *
	 */

	public function tearDown( ) {

		TestableTransformist::kill( );
	}
}



/**
 *
 */

class TestableTransformist extends Transformist {

	/**
	 *
	 */

	protected function __construct( ) { }



	/**
	 *
	 */

	public static function kill( ) {

		self::$_Instance = null;
	}



	/**
	 *
	 */

	public static function stub( $ConverterCollection ) {

		$_this = self::_instance( );
		$_this->_ConverterCollection = $ConverterCollection;
	}
}
