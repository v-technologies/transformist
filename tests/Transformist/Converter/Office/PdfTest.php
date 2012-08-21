<?php

if ( !defined( 'TRANSFORMIST_BOOTSTRAPPED' )) {
	require_once dirname( dirname( dirname( dirname( __FILE__ ))))
		. DIRECTORY_SEPARATOR . 'bootstrap.php';
}



/**
 *	Test case for Pdf.
 *
 *	@author Félix Girault <felix@vtech.fr>
 */

class Transformist_Converter_Office_PdfTest extends PHPUnit_Framework_TestCase {

	/**
	 *
	 */

	public function testSkip( ) {

		//$this->markTestIncomplete( );
	}



	/**
	 *
	 */

	/*
	public function testCanConvert( ) {

		$Document = new Transformist_Document(
			new Transformist_FileInfo( 'foo', 'application/msword' ),
			new Transformist_FileInfo( 'bar', 'application/pdf' )
		);

		$this->assertTrue( Transformist_Converter_Office_Pdf::canConvert( $Document ));
	}
	*/
}
