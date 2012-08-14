<?php

if ( !defined( 'TRANSFORMIST_BOOTSTRAPPED' )) {
	require_once dirname( dirname( __FILE__ ))
		. DIRECTORY_SEPARATOR . 'bootstrap.php';
}

define( 'CONVERTER_INPUT_TYPE', 'application/xml' );
define( 'CONVERTER_OUTPUT_TYPE', 'application/pdf' );

use org\bovigo\vfs\vfsStream;



/**
 *
 */

class Transformist_ConcreteConverter extends Transformist_Converter {

	/**
	 *
	 */

	protected $_inputType = CONVERTER_INPUT_TYPE;



	/**
	 *
	 */

	protected $_outputType = CONVERTER_OUTPUT_TYPE;



	/**
	 *
	 */

	protected function _convert( $Document ) { }

}



/**
 *	Test case for Converter.
 *
 *	@author Félix Girault <felix@vtech.fr>
 */

class Transformist_ConverterTest extends PHPUnit_Framework_TestCase {

	/**
	 *
	 */

	public $vfs = null;



	/**
	 *
	 */

	public $Converter = null;



	/**
	 *
	 */

	public function setUp( ) {

		$this->vfs = vfsStream::setup( 'root' );
		$this->vfs->addChild( vfsStream::newFile( 'readable.xml' ));
		$this->vfs->addChild( vfsStream::newFile( 'unreadable.xml', 0000 ));
		$this->vfs->addChild( vfsStream::newDirectory( 'writable' ));
		$this->vfs->addChild( vfsStream::newDirectory( 'unwritable', 0000 ));

		$this->Converter = new Transformist_ConcreteConverter( );
	}



	/**
	 *
	 */

	public function testCanConvert( ) {

		$Document = new Transformist_Document(
			new Transformist_FileInfo( 'foo', CONVERTER_INPUT_TYPE ),
			new Transformist_FileInfo( 'bar', CONVERTER_OUTPUT_TYPE )
		);

		$this->assertTrue( $this->Converter->canConvert( $Document ));

		$OtherDocument = new Transformist_Document(
			new Transformist_FileInfo( 'foo', 'unknown' ),
			new Transformist_FileInfo( 'bar', 'unknown' )
		);

		$this->assertFalse( $this->Converter->canConvert( $OtherDocument ));
	}



	/**
	 *
	 */

	public function testInputType( ) {

		$this->assertEquals( CONVERTER_INPUT_TYPE, $this->Converter->inputType( ));
	}



	/**
	 *
	 */

	public function testOutputType( ) {

		$this->assertEquals( CONVERTER_OUTPUT_TYPE, $this->Converter->outputType( ));
	}



	/**
	 *
	 */

	public function testConvertFromUnreadableFile( ) {

		$Document = new Transformist_Document(
			new Transformist_FileInfo( vfsStream::url( 'root/unreadable.xml' ), 'unknown' ),
			new Transformist_FileInfo( vfsStream::url( 'root/writable' ), 'unknown' )
		);

		$this->setExpectedException( 'Transformist_Exception' );
		$this->Converter->convert( $Document );
	}



	/**
	 *
	 */

	public function testConvertToUnwritableDir( ) {

		$Document = new Transformist_Document(
			new Transformist_FileInfo( vfsStream::url( 'root/readable.xml' ), 'unknown' ),
			new Transformist_FileInfo( vfsStream::url( 'root/unwritable/output' ), 'unknown' )
		);

		$this->setExpectedException( 'Transformist_Exception' );
		$this->Converter->convert( $Document );
	}
}
