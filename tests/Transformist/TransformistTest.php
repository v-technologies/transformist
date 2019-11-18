<?php

if ( !defined( 'TRANSFORMIST_BOOTSTRAPPED' )) {
	require_once dirname( dirname( __FILE__ ))
		. DIRECTORY_SEPARATOR . 'bootstrap.php';
}


use PHPUnit\Framework\TestCase;
use org\bovigo\vfs\vfsStream;



/**
 *	Test case for Transformist.
 *
 *	@author Félix Girault <felix@vtech.fr>
 */

class Transformist_TransformistTest extends TestCase {

	/**
	 *
	 */

	public $vfs = null;



	/**
	 *
	 */

	public $Transformist = null;



	/**
	 *
	 */

	public $MultistepTransformist = null;



	/**
	 *
	 */

	public function setUp( ) : void {

		if ( !class_exists( '\\org\\bovigo\\vfs\\vfsStream' )) {
			$this->markTestSkipped( 'vfsStream must be enabled.' );
		}

		Runkit::requiredBy( $this );
		Runkit::redefineConstant( 'TRANSFORMIST_ROOT', TRANSFORMIST_TEST_RESOURCE );

		$this->vfs = vfsStream::setup( 'root' );
		$this->vfs->addChild( vfsStream::newFile( 'readable.txt' ));
		$this->vfs->addChild( vfsStream::newFile( 'unreadable.txt', 0000 ));
		$this->vfs->addChild( vfsStream::newDirectory( 'writable' ));
		$this->vfs->addChild( vfsStream::newDirectory( 'unwritable', 0000 ));

		$this->Transformist = new Transformist( );
		$this->MultistepTransformist = new Transformist( array( 'multistep' => true ));
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
				)
			),
			$this->Transformist->availableConversions( )
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

		$this->assertTrue( $this->Transformist->canConvert( $Document ));
	}



	/**
	 *
	 */

	public function testCantConvert( ) {

		$Document = new Transformist_Document(
			new Transformist_FileInfo( 'foo', 'text/plain' ),
			new Transformist_FileInfo( 'bar', 'unknown' )
		);

		$this->assertFalse( $this->Transformist->canConvert( $Document ));
	}



	/**
	 *
	 */

	public function testConvert( ) {

		$Document = new Transformist_Document(
			new Transformist_FileInfo( vfsStream::url( 'root/readable.txt' ), 'text/plain' ),
			new Transformist_FileInfo( vfsStream::url( 'root/writable/converted.html' ), 'text/html' )
		);

		$this->Transformist->addDocument( $Document );
		$this->assertTrue( $this->Transformist->run( ));
	}



	/**
	 *
	 */

	public function testConvertFromUnreadableFile( ) {

		$Document = new Transformist_Document(
			new Transformist_FileInfo( vfsStream::url( 'root/unreadable.txt' )),
			new Transformist_FileInfo( vfsStream::url( 'root/writable/foo.bar' ))
		);

		$this->Transformist->addDocument( $Document );
		$this->assertFalse( $this->Transformist->run( ));
	}



	/**
	 *
	 */

	public function testConvertToUnwritableDir( ) {

		$Document = new Transformist_Document(
			new Transformist_FileInfo( vfsStream::url( 'root/readable.txt' )),
			new Transformist_FileInfo( vfsStream::url( 'root/unwritable/converted' ))
		);

		$this->Transformist->addDocument( $Document );
		$this->assertFalse( $this->Transformist->run( ));
	}



	/**
	 *
	 */

	public function testSetup( ) {

		$this->Transformist->setup(
			vfsStream::url( 'root' ),
			array(
				'readable.txt' => 'text/html'
			)
		);

		$this->assertTrue( $this->Transformist->run( ));
	}



	/**
	 *
	 */

	public function tearDown( ) : void {

		Runkit::resetConstant( 'TRANSFORMIST_ROOT' );
	}
}
