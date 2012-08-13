<?php

if ( !defined( 'TRANSFORMIST_BOOTSTRAPPED' )) {
	require_once dirname( dirname( __FILE__ ))
		. DIRECTORY_SEPARATOR . 'bootstrap.php';
}

define(
	'TEST_FILE_PATH',
	TRANSFORMIST_TEST_ROOT . 'files' . DS . 'input' . DS  . 'doc-sample.doc'
);



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

		// we can cover more code with runkit

		if ( extension_loaded( 'runkit' )) {

			// from now on class_exists( ) will always return false
			runkit_function_rename( 'class_exists', '__original_class_exists' );
			runkit_function_add( 'class_exists', '$className', 'return false;' );

			$FileInfo = new Transformist_FileInfo( $this->filePath );
			$raisedException = false;

			try {
				$FileInfo->type( );
			} catch ( Transformist_Exception $e ) {
				$raisedException = true;
			}

			$this->assertTrue( $raisedException );

			// resetting original class_exists function
			runkit_function_remove( 'class_exists' );
			runkit_function_rename( '__original_class_exists', 'class_exists' );

			/*
			// from now on finfo::file( ) will always return false
			runkit_method_rename( 'finfo', 'file', '__original_file' );
			runkit_method_add( 'finfo', 'file', '$fileName', 'return false;' );

			// resetting original finfo::file method
			runkit_method_remove( 'finfo', 'file' );
			runkit_method_rename( 'finfo', '__original_file', 'file' );
			*/
		}
	}
}
