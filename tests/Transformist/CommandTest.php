<?php

if ( !defined( 'TRANSFORMIST_BOOTSTRAPPED' )) {
	require_once dirname( dirname( __FILE__ ))
		. DIRECTORY_SEPARATOR . 'bootstrap.php';
}



/**
 *	Test case for Command.
 *
 *	@author Félix Girault <felix@vtech.fr>
 */

class Transformist_CommandTest extends PHPUnit_Framework_TestCase {

	/**
	 *
	 */

	public function setUp( ) {

		Runkit::requiredBy( $this );
		Runkit::reimplementFunction(
			'exec',
			'$command, &$output, &$status',
			'$output = array( ); $status = 0;'
		);
	}



	/**
	 *
	 */

	public function testExecute( ) {

		$Command = new Transformist_Command( 'ls' );

		$this->assertEquals(
			new Transformist_CommandResult( 'ls', array( ), 0 ),
			$Command->execute( )
		);
	}



	/**
	 *
	 */

	public function testExecuteWithFlags( ) {

		$Command = new Transformist_Command( 'ls' );

		$this->assertEquals(
			new Transformist_CommandResult( 'ls -a -l', array( ), 0 ),
			$Command->execute( array( '-a', '-l' ))
		);
	}



	/**
	 *
	 */

	public function testExecuteWithOptions( ) {

		$Command = new Transformist_Command( 'ls' );

		$this->assertEquals(
			new Transformist_CommandResult( 'ls --tabsize 5', array( ), 0 ),
			$Command->execute( array( '--tabsize' => 5 ))
		);
	}



	/**
	 *
	 */

	public function testExecuteWithCustomAssignment( ) {

		$Command = new Transformist_Command( 'ls', '=' );

		$this->assertEquals(
			new Transformist_CommandResult( 'ls --tabsize=5', array( ), 0 ),
			$Command->execute( array( '--tabsize' => 5 ))
		);
	}



	/**
	 *
	 */

	public function tearDown( ) {

		Runkit::resetFunction( 'exec' );
	}
}
