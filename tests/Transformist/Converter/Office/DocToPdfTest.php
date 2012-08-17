<?php

if ( !defined( 'TRANSFORMIST_BOOTSTRAPPED' )) {
	require_once dirname( dirname( dirname( dirname( __FILE__ ))))
		. DIRECTORY_SEPARATOR . 'bootstrap.php';
}



/**
 *	Test case for DocToPdf.
 *
 *	@author Félix Girault <felix@vtech.fr>
 */

class Transformist_Converter_Office_DocToPdfTest extends PHPUnit_Framework_TestCase {

	/**
	 *
	 */

	public $DocToPdf = null;



	/**
	 *
	 */

	public function setup( ) {

		$this->DocToPdf = new Transformist_Converter_Office_DocToPdf( );
	}



	/**
	 *
	 */

	public function testCanConvert( ) {

		$Document = new Transformist_Document(
			new Transformist_FileInfo( 'foo', 'application/msword' ),
			new Transformist_FileInfo( 'bar', 'application/pdf' )
		);

		$this->assertTrue( $this->DocToPdf->canConvert( $Document ));
	}
}
