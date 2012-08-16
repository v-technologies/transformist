<?php

if ( !defined( 'TRANSFORMIST_BOOTSTRAPPED' )) {
	require_once dirname( dirname( __FILE__ ))
		. DIRECTORY_SEPARATOR . 'bootstrap.php';
}

use org\bovigo\vfs\vfsStream;



/**
 *	Test case for FileInfo.
 *
 *	@author Félix Girault <felix@vtech.fr>
 */

class Transformist_FileInfoTest extends PHPUnit_Framework_TestCase {

	/**
	 *
	 */

	public $vfs = null;



	/**
	 *
	 */

	public $XmlFileInfo = null;
	public $GifFileInfo = null;



	/**
	 *
	 */

	public function setUp( ) {

		if ( !class_exists( '\\org\\bovigo\\vfs\\vfsStream' )) {
			$this->markTestAsSkipped( 'vfsStream must be enabled.' );
		}

		$this->vfs = vfsStream::setup( 'root' );

		$accessible = vfsStream::newDirectory( 'accessible' );
		$accessible->addChild(
			vfsStream::newFile( 'foo.xml' )
				->withContent( '<?xml version="1.0" encoding="UTF-8"?>' )
		);
		$accessible->addChild(
			vfsStream::newFile( 'empty' )
				->withContent( '' )
		);
		$this->vfs->addChild( $accessible );

		$restricted = vfsStream::newDirectory( 'restricted', 0000 );
		$accessible->addChild(
			vfsStream::newFile( 'bar.gif', 0000 )
				->withContent( 'GIF' )
		);
		$this->vfs->addChild( $restricted );

		$this->XmlFileInfo = new Transformist_FileInfo( vfsStream::url( 'root/accessible/foo.xml' ));
		$this->GifFileInfo = new Transformist_FileInfo( vfsStream::url( 'root/restricted/bar.gif' ));
	}



	/**
	 *
	 */

	public function testExists( ) {

		$this->assertTrue( $this->XmlFileInfo->exists( ));
	}



	/**
	 *
	 */

	public function testBaseName( ) {

		$this->assertEquals( 'foo', $this->XmlFileInfo->baseName( ));
	}



	/**
	 *
	 */

	public function testIsReadable( ) {

		$this->assertTrue( $this->XmlFileInfo->isReadable( ));
		$this->assertFalse( $this->GifFileInfo->isReadable( ));
	}



	/**
	 *
	 */

	public function testIsWritable( ) {

		$this->assertTrue( $this->XmlFileInfo->isWritable( ));
		$this->assertFalse( $this->GifFileInfo->isWritable( ));
	}



	/**
	 *
	 */

	public function testIsDirReadable( ) {

		$this->assertTrue( $this->XmlFileInfo->isDirReadable( ));
		$this->assertFalse( $this->GifFileInfo->isDirReadable( ));
	}



	/**
	 *
	 */

	public function testIsDirWritable( ) {

		$this->assertTrue( $this->XmlFileInfo->isDirWritable( ));
		$this->assertFalse( $this->GifFileInfo->isDirWritable( ));
	}



	/**
	 *
	 */

	public function testPath( ) {

		$this->assertEquals(
			vfsStream::url( 'root/accessible/foo.xml' ),
			$this->XmlFileInfo->path( )
		);
	}



	/**
	 *
	 */

	public function testDirPath( ) {

		$this->assertEquals(
			dirname( vfsStream::url( 'root/accessible/foo.xml' )),
			$this->XmlFileInfo->dirPath( )
		);
	}



	/**
	 *
	 */

	public function testSplFileInfo( ) {

		$SplFileInfo = $this->XmlFileInfo->splFileInfo( );

		$this->assertTrue( $SplFileInfo instanceof SplFileInfo );
	}



	/**
	 *
	 */

	public function testType( ) {

		$this->assertEquals( 'application/xml', $this->XmlFileInfo->type( ));
	}



	/**
	 *
	 */

	public function testForcedType( ) {

		$FileInfo = new Transformist_FileInfo( '', 'application/pdf' );
		$this->assertEquals( 'application/pdf', $FileInfo->type( ));
	}



	/**
	 *
	 */

	public function testUndeterminableType( ) {

		$caught = false;

		try {
			$this->GifFileInfo->type( );
		} catch ( Transformist_Exception $e ) {
			$caught = true;
		}

		$this->assertTrue( $caught );
	}



	/**
	 *
	 */

	public function testTypeWithoutFileInfo( ) {

		if ( !Runkit::isEnabled( )) {
			$this->markTestAsSkipped( 'Runkit must be enabled.' );
		}

		Runkit::reimplement( 'class_exists', '$className', 'return false;' );

		$FileInfo = new Transformist_FileInfo( vfsStream::url( 'root/accessible/empty' ));
		$caught = false;

		try {
			$FileInfo->type( );
		} catch ( Transformist_Exception $e ) {
			$caught = true;
		}

		$this->assertTrue( $caught );

		Runkit::reset( 'class_exists' );
	}
}
