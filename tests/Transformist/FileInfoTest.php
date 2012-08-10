<?php

if ( !defined( 'INCLUDED' )) {
	require_once( dirname( dirname( __FILE__ )) . DIRECTORY_SEPARATOR . 'bootstrap.php' );
}

define( 'TEST_FILE_PATH', TRANSFORMIST_TEST_ROOT . 'files' . DS . 'input' . DS  . 'doc-sample.doc' );



/**
 *	Test case for FileInfo.
 *
 *	@author Félix Girault <felix@vtech.fr>
 */

class Transformist_FileInfoTest extends PHPUnit_Framework_TestCase {

	/**
	 *	This must be the path to an existing file for the test case to be
	 *	executed properly.
	 */

	public $filePath = TEST_FILE_PATH;



	/**
	 *
	 */

	public $FileInfo = null;



	/**
	 *
	 */

	public function setUp( ) {

		$this->FileInfo = new Transformist_FileInfo( $this->filePath );
	}



	/**
	 *
	 */

	public function testExists( ) {

		$this->assertTrue( $this->FileInfo->exists( ));
	}



	/**
	 *
	 */

	public function testBaseName( ) {

		$this->assertEquals( 'doc-sample', $this->FileInfo->baseName( ));
	}



	/**
	 *
	 */

	public function testIsReadable( ) {


	}



	/**
	 *
	 */

	public function testIsWritable( ) {


	}



	/**
	 *
	 */

	public function testIsDirReadable( ) {


	}



	/**
	 *
	 */

	public function testIsDirWritable( ) {


	}



	/**
	 *
	 */

	public function testPath( ) {

		$this->assertEquals( $this->filePath, $this->FileInfo->path( ));
	}



	/**
	 *
	 */

	public function testDirPath( ) {

		$this->assertEquals( dirname( $this->filePath ), $this->FileInfo->dirPath( ));
	}



	/**
	 *
	 */

	public function testSplFileInfo( ) {

		$SplFileInfo = $this->FileInfo->splFileInfo( );

		$this->assertTrue( $SplFileInfo instanceof SplFileInfo );
	}



	/**
	 *
	 */

	public function testType( ) {

		$FileInfo = new Transformist_FileInfo( $this->filePath, 'application/pdf' );

		$this->assertEquals( 'application/pdf', $FileInfo->type( ));
		$this->assertEquals( 'application/msword', $this->FileInfo->type( ));
	}
}
