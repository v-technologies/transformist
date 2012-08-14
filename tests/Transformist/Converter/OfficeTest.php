<?php

if ( !defined( 'TRANSFORMIST_BOOTSTRAPPED' )) {
	require_once dirname( dirname( dirname( __FILE__ )))
		. DIRECTORY_SEPARATOR . 'bootstrap.php';
}

define(
	'OFFICE_INPUT_FILE',
	TRANSFORMIST_TEST_ROOT . 'files' . DS . 'input' . DS . 'sample.doc'
);

define(
	'OFFICE_OUTPUT_FILE_1',
	TRANSFORMIST_TEST_ROOT . 'files' . DS . 'output' . DS . 'sample.pdf'
);

define(
	'OFFICE_OUTPUT_FILE_2',
	TRANSFORMIST_TEST_ROOT . 'files' . DS . 'output' . DS . 'converted.pdf'
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

	public function setUp( ) {

		if ( file_exists( OFFICE_OUTPUT_FILE_1 )) {
			unlink( OFFICE_OUTPUT_FILE_1 );
		}

		if ( file_exists( OFFICE_OUTPUT_FILE_2 )) {
			unlink( OFFICE_OUTPUT_FILE_2 );
		}
	}



	/**
	 *
	 */

	public function testConvert( ) {

		$Document = new Transformist_Document(
			new Transformist_FileInfo( OFFICE_INPUT_FILE ),
			new Transformist_FileInfo( OFFICE_OUTPUT_FILE_1 )
		);

		$Office = new Transformist_Converter_ConcreteOffice( );
		$Office->convert( $Document );

		$this->assertTrue( file_exists( OFFICE_OUTPUT_FILE_1 ));
	}



	/**
	 *
	 */

	public function testConvertWithNewName( ) {

		$Document = new Transformist_Document(
			new Transformist_FileInfo( OFFICE_INPUT_FILE ),
			new Transformist_FileInfo( OFFICE_OUTPUT_FILE_2 )
		);

		$Office = new Transformist_Converter_ConcreteOffice( );
		$Office->convert( $Document );

		$this->assertTrue( file_exists( OFFICE_OUTPUT_FILE_2 ));
	}



	/**
	 *
	 */

	public function testConvertWithBrokenImplementation( ) {

		$this->setExpectedException( 'Transformist_Exception' );

		$Document = new Transformist_Document(
			new Transformist_FileInfo( OFFICE_INPUT_FILE ),
			new Transformist_FileInfo( OFFICE_OUTPUT_FILE_1 )
		);

		$Office = new Transformist_Converter_BrokenOffice( );
		$Office->convert( $Document );
	}
}



/**
 *
 */

class Transformist_Converter_ConcreteOffice extends Transformist_Converter_Office {

	protected $_inputType = 'application/msword';
	protected $_outputType = 'application/pdf';

	protected $_printer = 'writer_pdf_Export';

}



/**
 *
 */

class Transformist_Converter_BrokenOffice extends Transformist_Converter_Office {

	protected $_inputType = '';
	protected $_outputType = '';

	protected $_printer = '';

}
