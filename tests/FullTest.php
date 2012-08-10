<?php

require_once( 'bootstrap.php' );



/**
 *	Lists and executes all test cases located in subdirectories.
 */

class FullTest {

	/**
	 *	Constructs and returns a test suite covering all available tests cases.
	 *
	 *	@return PHPUnit_Framework_TestSuite Suite.
	 */

	public static function suite( ) {

		$Suite = new PHPUnit_Framework_TestSuite( );

		self::_output( 'Searching for test cases in ' . TRANSFORMIST_TEST_ROOT . '...' );
		$Package = new Transformist_Package( TRANSFORMIST_TEST_ROOT );
		$tests = $Package->classes( array( 'Transformist' ), true );

		if ( empty( $tests )) {
			self::_output( 'No case found.' );
		} else {
			self::_output( 'Found ' . count( $tests ) . ' cases :' );

			foreach ( $tests as $test ) {
				self::_output( '- ' . $test );
				$Suite->addTestSuite( $test );
			}
		}

		self::_output( '' );
		return $Suite;
	}



	/**
	 *	Outputs a line of text.
	 *
	 *	@param string $line Text to output.
	 */

	protected static function _output( $line ) {

		echo $line, PHP_EOL;
	}
}
