<?php

require_once( 'bootstrap.php' );



/**
 *	Lists and executes all test cases located in subdirectories.
 *
 *	@author Félix Girault <felix@vtech.fr>
 */

class AllTests {

	/**
	 *
	 */

	protected static $_path = TRANSFORMIST_TEST_ROOT;



	/**
	 *	Constructs and returns a test suite covering all available tests cases.
	 *
	 *	@return PHPUnit_Framework_TestSuite Suite.
	 */

	public static function suite( ) {

		$Suite = new PHPUnit_Framework_TestSuite( );

		self::_output( 'Searching for test cases in %s...', self::$_path );
		self::_output( '' );

		$Package = new Transformist_Package( self::$_path );
		$tests = $Package->classes( array( 'Transformist' ), true );

		if ( empty( $tests )) {
			self::_output( 'No case found.' );
		} else {
			self::_output( 'Found %d cases :', count( $tests ));

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
	 *	@param mixed... A list of arguments.
	 */

	protected static function _output( $line, $arguments = null ) {

		if ( func_num_args( ) > 1 ) {
			$line = vsprintf( $line, array_slice( func_get_args( ), 1 ));
		}

		echo $line, PHP_EOL;
	}
}
