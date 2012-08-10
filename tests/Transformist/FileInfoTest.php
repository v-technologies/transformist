<?php

if ( !defined( 'INCLUDED' )) {
	require_once( dirname( dirname( __FILE__ )) . DIRECTORY_SEPARATOR . 'bootstrap.php' );
}

define( 'TEST_FILE_PATH', TRANSFORMIST_TEST_ROOT . 'files' . DS . 'input' . DS  . 'doc-sample.doc' );



/**
 *	Test case for FileInfo.
 */

class Transformist_FileInfoTest extends PHPUnit_Framework_TestCase {

	/**
	 *
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

		// we need the file to run the test
		$this->assertTrue( file_exists( $this->filePath ));

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

		$this->assertEquals( $this->FileInfo->baseName( ), 'doc-sample' );
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

		$this->assertEquals( $this->FileInfo->path( ), $this->filePath );
	}



	/**
	 *
	 */

	public function testDirPath( ) {

		$this->assertEquals( $this->FileInfo->dirPath( ), dirname( $this->filePath ));
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

		$this->assertEquals( $FileInfo->type( ), 'application/pdf' );
		$this->assertEquals( $this->FileInfo->type( ), 'application/msword' );
	}
}
