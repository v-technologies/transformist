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

	public $commands = array(

		// simple command
		array(
			'name' => 'ls',
			'options' => array( ),
			'assignment' => ' '
		),

		// command with short options
		array(
			'name' => 'ls',
			'options' => array( '-a', '-b' ),
			'assignment' => ' '
		),

		// command with long options
		array(
			'name' => 'ls',
			'options' => array(
				'--color' => 'never',
				'--width' => '80'
			),
			'assignment' => ' '
		),

		// command with mixed options and a custom assignment character
		array(
			'name' => 'ls',
			'options' => array(
				'-a',
				'--width' => '80'
			),
			'assignment' => '='
		)
	);



	/**
	 *
	 */

	public $results = array(
		array(
			'command' => 'ls',
			'output' => array( ),
			'status' => 0
		),
		array(
			'command' => 'ls -a -b',
			'output' => array( ),
			'status' => 0
		),
		array(
			'command' => 'ls --color never --width 80',
			'output' => array( ),
			'status' => 0
		),
		array(
			'command' => 'ls -a --width=80',
			'output' => array( ),
			'status' => 0
		)
	);



	/**
	 *
	 */

	public function setUp( ) {

		if ( !Runkit::isEnabled( )) {
			$this->markTestAsSkipped( 'Runkit must be enabled.' );
		}

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

		foreach ( $this->commands as $index => $command ) {
			extract( $command );

			$this->assertEquals(
				$this->results[ $index ],
				Transformist_Command::execute( $name, $options, $assignment )
			);
		}
	}



	/**
	 *
	 */

	public function testExecuted( ) {

		$this->assertEquals( $this->results, Transformist_Command::executed( ));
	}



	/**
	 *
	 */

	public function testLast( ) {

		$this->assertEquals( array_pop( $this->results ), Transformist_Command::last( ));
	}



	/**
	 *
	 */

	public function tearDown( ) {

		Runkit::resetFunction( 'exec' );
	}
}
