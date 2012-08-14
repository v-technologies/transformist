<?php

if ( !defined( 'TRANSFORMIST_BOOTSTRAPPED' )) {
	require_once dirname( dirname( __FILE__ ))
		. DIRECTORY_SEPARATOR . 'bootstrap.php';
}

use org\bovigo\vfs\vfsStream;



/**
 *	Test case for ConverterCollection.
 *
 *	@author Félix Girault <felix@vtech.fr>
 */

class Transformist_ConverterCollectionTest extends PHPUnit_Framework_TestCase {

	/**
	 *
	 */

	public $vfs = null;



	/**
	 *
	 */

	public $textToHtml = <<<'CODE'
		class Transformist_Converter_TextToHtml extends Transformist_Converter {

			protected $_inputType = 'text/plain';
			protected $_outputType = 'text/html';

			protected function _convert( $Document ) {

			}
		}
CODE;



	/**
	 *
	 */

	public $htmlToXml = <<<'CODE'
		class Transformist_Converter_TextToHtml extends Transformist_Converter {

			protected $_inputType = 'text/html';
			protected $_outputType = 'application/xml';

			protected function _convert( $Document ) {

			}
		}
CODE;



	/**
	 *
	 */

	public function setup( ) {

		$this->vfs = vfsStream::setup(
			'root',
			null,
			array(
				'Transformist' => array(
					'Converter' => array(
						'First.php' => $this->textToHtml,
						'Second.php' => 'class Transformist_Converter_Second { }',
						'First.php' => 'class Transformist_Converter_First { }',
						'First.php' => 'class Transformist_Converter_First { }',
						'First.php' => 'class Transformist_Converter_First { }',
						'First.php' => 'class Transformist_Converter_First { }',
						'First.php' => 'class Transformist_Converter_First { }',
						'First.php' => 'class Transformist_Converter_First { }',
						'First.php' => 'class Transformist_Converter_First { }',
					)
				)
			)
		);
	}



	/**
	 *
	 */

	public function testConstruct( ) {

		if ( Runkit::isEnabled( )) {
			Runkit::redefine( 'TRANSFORMIST_ROOT', vfsStream::url( 'root' ));



			Runkit::reset( 'TRANSFORMIST_ROOT' );
		}
	}



	/**
	 *
	 */

	public function testAvailableConversions( ) {


	}



	/**
	 *
	 */

	public function testCanConvert( ) {

	}



	/**
	 *
	 */

	public function testConvert( ) {

	}
}
