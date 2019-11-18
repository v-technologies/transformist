<?php

if ( !defined( 'TRANSFORMIST_BOOTSTRAPPED' )) {
	require_once dirname( dirname( __FILE__ ))
		. DIRECTORY_SEPARATOR . 'bootstrap.php';
}

use PHPUnit\Framework\TestCase;
use org\bovigo\vfs\vfsStream;


/**
 *	Test case for Document.
 *
 *	@author Félix Girault <felix@vtech.fr>
 */

class Transformist_DocumentTest extends TestCase {

	/**
	 *
	 */

	public $vfs = null;



	/**
	 *
	 */

	public $Document = null;



	/**
	 *
	 */

	public $Input = null;



	/**
	 *
	 */

	public $Output = null;



	/**
	 *
	 */

	public function setUp( ) : void {

		if ( !class_exists( '\\org\\bovigo\\vfs\\vfsStream' )) {
			$this->markTestSkipped( 'vfsStream must be enabled.' );
		}

		$this->vfs = vfsStream::setup( 'root', null, array( 'input.txt' ));

		$this->Input = new Transformist_FileInfo( vfsStream::url( 'root/input.txt' ));
		$this->Output = new Transformist_FileInfo( vfsStream::url( 'root/output.doc' ));
		$this->Document = new Transformist_Document( $this->Input, $this->Output );
	}



	/**
	 *
	 */

	public function testInput( ) {

		$this->assertEquals( $this->Input, $this->Document->input( ));
	}



	/**
	 *
	 */

	public function testOutput( ) {

		$this->assertEquals( $this->Output, $this->Document->output( ));
	}



	/**
	 *
	 */

	public function testIsConverted( ) {

		$this->vfs->addChild( vfsStream::newFile( 'output.doc' ));
		$this->assertTrue( $this->Document->isConverted( ));
	}



	/**
	 *
	 */

	public function testIsntConverted( ) {

		$this->assertFalse( $this->Document->isConverted( ));
	}
}
