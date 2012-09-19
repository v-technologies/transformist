<?php

if ( !defined( 'TRANSFORMIST_BOOTSTRAPPED' )) {
	require_once dirname( dirname( dirname( __FILE__ )))
		. DIRECTORY_SEPARATOR . 'bootstrap.php';
}

define(
	'OFFICE_INPUT_FILE',
	TRANSFORMIST_TEST_RESOURCE . 'File' . DS . 'Input' . DS . 'sample.doc'
);

define(
	'OFFICE_OUTPUT_FILE',
	TRANSFORMIST_TEST_RESOURCE . 'File' . DS . 'Output' . DS . 'converted.pdf'
);



/**
 *	Test case for Office.
 *
 *	@author Félix Girault <felix@vtech.fr>
 */

class Transformist_Converter_OfficeTest extends PHPUnit_Framework_TestCase {

	/**
	 *
	 */

	public $Office = null;



	/**
	 *
	 */

	public $Document = null;



	/**
	 *
	 */

	public function setUp( ) {

		$runnable = Transformist_Converter_Office::isRunnable( );

		if ( $runnable !== true ) {
			$this->markTestSkipped( $runnable );
		}

		Transformist_cleanDirectory( dirname( OFFICE_OUTPUT_FILE ));

		$this->Office = new Transformist_Converter_Office( );
		$this->Document = new Transformist_Document(
			new Transformist_FileInfo( OFFICE_INPUT_FILE ),
			new Transformist_FileInfo( OFFICE_OUTPUT_FILE, 'application/pdf' )
		);
	}



	/**
	 *
	 */

	public function testConvert( ) {

		$this->Office->convert( $this->Document );
		$this->assertTrue( $this->Document->isConverted( ));
	}
}
