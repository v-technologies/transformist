<?php

if ( !defined( 'TRANSFORMIST_BOOTSTRAPPED' )) {
	require_once dirname( dirname( __FILE__ ))
		. DIRECTORY_SEPARATOR . 'bootstrap.php';
}

use org\bovigo\vfs\vfsStream;



/**
 *	Test case for ConverterCollection.
 *
 *	@author Félix Girault <felix@vtech.fr>
 */

class Transformist_ConverterCollectionTest extends PHPUnit_Framework_TestCase {

	/**
	 *
	 */

	public $vfs = null;



	/**
	 *
	 */

	public $Collection = null;



	/**
	 *
	 */

	public function setup( ) {

		if ( !class_exists( '\\org\\bovigo\\vfs\\vfsStream' )) {
			$this->markTestAsSkipped( 'vfsStream must be enabled.' );
		}

		if ( !Runkit::isEnabled( )) {
			$this->markTestAsSkipped( 'Runkit must be enabled.' );
		}

		Runkit::redefineConstant( 'TRANSFORMIST_ROOT', TRANSFORMIST_TEST_RESOURCE );

		$this->vfs = vfsStream::setup( 'root' );
		$this->vfs->addChild( vfsStream::newFile( 'readable.txt' ));
		$this->vfs->addChild( vfsStream::newFile( 'unreadable.txt', 0000 ));
		$this->vfs->addChild( vfsStream::newDirectory( 'writable' ));
		$this->vfs->addChild( vfsStream::newDirectory( 'unwritable', 0000 ));

		$this->Collection = new Transformist_ConverterCollection( );
		$this->MultistepCollection = new Transformist_ConverterCollection( true );
	}



	/**
	 *
	 */

	public function testAvailableConversions( ) {

		$this->assertEquals(
			array(
				'text/plain' => array(
					'text/html'
				),
				'application/xml' => array(
					'application/json'
				),
				'text/html' => array(
					'application/xml'
				),
				'image/svg+xml' => array(
					'application/xml'
				)
			),
			$this->Collection->availableConversions( )
		);
	}



	/**
	 *
	 */

	public function testAvailableMultistepConversions( ) {

		$this->assertEquals(
			array(
				'text/plain' => array(
					'text/html',
					'application/xml',
					'application/json'
				),
				'application/xml' => array(
					'application/json'
				),
				'text/html' => array(
					'application/xml',
					'application/json'
				),
				'image/svg+xml' => array(
					'application/xml',
					'application/json'
				)
			),
			$this->MultistepCollection->availableConversions( )
		);
	}



	/**
	 *
	 */

	public function testCanConvert( ) {

		$Document = new Transformist_Document(
			new Transformist_FileInfo( vfsStream::url( 'root/readable.txt' ), 'text/plain' ),
			new Transformist_FileInfo( vfsStream::url( 'root/writable/converted.html' ), 'text/html' )
		);

		$this->assertTrue( $this->Collection->canConvert( $Document ));
	}



	/**
	 *
	 */

	public function testCanConvertMultistep( ) {

		$Document = new Transformist_Document(
			new Transformist_FileInfo( vfsStream::url( 'root/readable.txt' ), 'text/plain' ),
			new Transformist_FileInfo( vfsStream::url( 'root/writable/converted.json' ), 'application/json' )
		);

		$this->assertEquals( 3, $this->MultistepCollection->canConvert( $Document ));
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
			new Transformist_FileInfo( vfsStream::url( 'root/readable.txt' ), 'text/plain' ),
			new Transformist_FileInfo( vfsStream::url( 'root/writable/converted.html' ), 'text/html' )
		);

		$this->Collection->convert( $Document );

		$this->assertTrue( $Document->isConverted( ));
	}



	/**
	 *
	 */

	public function testConvertMultistep( ) {

		$Document = new Transformist_Document(
			new Transformist_FileInfo( vfsStream::url( 'root/readable.txt' ), 'text/plain' ),
			new Transformist_FileInfo( vfsStream::url( 'root/writable/converted.json' ), 'application/json' )
		);

		$this->MultistepCollection->convert( $Document );

		$this->assertTrue( $Document->isConverted( ));
	}



	/**
	 *
	 */

	public function testConvertFromUnreadableFile( ) {

		$Document = new Transformist_Document(
			new Transformist_FileInfo( vfsStream::url( 'root/unreadable.txt' )),
			new Transformist_FileInfo( vfsStream::url( 'root/writable' ))
		);

		$this->setExpectedException( 'Transformist_Exception' );
		$this->Collection->convert( $Document );
	}



	/**
	 *
	 */

	public function testConvertToUnwritableDir( ) {

		$Document = new Transformist_Document(
			new Transformist_FileInfo( vfsStream::url( 'root/readable.txt' )),
			new Transformist_FileInfo( vfsStream::url( 'root/unwritable/converted' ))
		);

		$this->setExpectedException( 'Transformist_Exception' );
		$this->Collection->convert( $Document );
	}



	/**
	 *
	 */

	public function tearDown( ) {

		Runkit::resetConstant( 'TRANSFORMIST_ROOT' );
	}
}
