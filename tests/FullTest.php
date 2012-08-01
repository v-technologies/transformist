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

		self::_output( 'Searching for test cases in ' . TRANSFORMIST_TEST_ROOT . '...' );

		$tests = self::_tests( );
		$Suite = new PHPUnit_Framework_TestSuite( );

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



	/**
	 *	Searches recursively for every test class available in subdirectories.
	 *	ie. each filename ending with Test.php.
	 *
	 *	@param array $package An array of package names.
	 *	@return array Found test cases.
	 */

	protected static function _tests( $package = array( )) {

		$directory = TRANSFORMIST_TEST_ROOT . self::_path( $package, DS );
		$entries = scandir( $directory );
		$tests = array( );

		foreach ( $entries as $entry ) {
			if ( is_dir( $directory . $entry )) {
				if (( $entry != '.' ) && ( $entry != '..' )) {
					$subPackage = $package;
					$subPackage[] = $entry;

					$tests = array_merge( $tests, self::_tests( $subPackage ));
				}
			}

			if ( !empty( $package ) && strpos( $entry, 'Test.php' ) !== false ) {
				$tests[] = self::_path( $package, '_' ) . basename( $entry, '.php' );
			}
		}

		return $tests;
	}



	/**
	 *	Joins the given parts with a delimiter, and adds a trailing delimiter.
	 *
	 *	@param array $parts An array of strings to join.
	 *	@param string $delimiter The path delimiter.
	 *	@return string Path.
	 */

	protected static function _path( $parts = array( ), $delimiter ) {

		if ( empty( $parts )) {
			return '';
		}

		return implode( $delimiter, $parts ) . $delimiter;
	}
}
