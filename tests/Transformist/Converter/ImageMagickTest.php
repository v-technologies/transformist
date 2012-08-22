<?php

if ( !defined( 'TRANSFORMIST_BOOTSTRAPPED' )) {
	require_once dirname( dirname( dirname( __FILE__ )))
		. DIRECTORY_SEPARATOR . 'bootstrap.php';
}

define(
	'IMAGEMAGICK_INPUT_FILE',
	TRANSFORMIST_TEST_RESOURCE . 'File' . DS . 'Input' . DS . 'sample.jpg'
);

define(
	'IMAGEMAGICK_OUTPUT_FILE',
	TRANSFORMIST_TEST_RESOURCE . 'File' . DS . 'Output' . DS . 'converted.png'
);



/**
 *	Test case for ImageMagick.
 *
 *	@author Félix Girault <felix@vtech.fr>
 */

class Transformist_Converter_ImageMagickTest extends PHPUnit_Framework_TestCase {

	/**
	 *
	 */

	public $ImageMagick = null;



	/**
	 *
	 */

	public $Document = null;



	/**
	 *
	 */

	public function setUp( ) {

		Transformist_cleanDirectory( dirname( IMAGEMAGICK_OUTPUT_FILE ));

		$this->ImageMagick = new Transformist_Converter_ImageMagick_Concrete( );
		$this->Document = new Transformist_Document(
			new Transformist_FileInfo( IMAGEMAGICK_INPUT_FILE ),
			new Transformist_FileInfo( IMAGEMAGICK_OUTPUT_FILE, 'image/png' )
		);
	}



	/**
	 *
	 */

	public function testConvert( ) {

		$this->ImageMagick->convert( $this->Document );

		$this->assertTrue( file_exists( IMAGEMAGICK_OUTPUT_FILE ));
	}
}



/**
 *
 */

class Transformist_Converter_ImageMagick_Concrete extends Transformist_Converter_ImageMagick {

	public static function inputTypes( ) {

		return array( 'image/jpeg' );
	}

	public static function outputType( ) {

		return 'image/png';
	}
}
