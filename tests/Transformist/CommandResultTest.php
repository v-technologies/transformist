<?php

if ( !defined( 'TRANSFORMIST_BOOTSTRAPPED' )) {
	require_once dirname( dirname( __FILE__ ))
		. DIRECTORY_SEPARATOR . 'bootstrap.php';
}



/**
 *	Test case for CommandResult.
 *
 *	@author Félix Girault <felix@vtech.fr>
 */

class Transformist_CommandResultTest extends PHPUnit_Framework_TestCase {

	/**
	 *
	 */

	public $Result = null;



	/**
	 *
	 */

	public function setUp( ) {

		$this->Result = new Transformist_CommandResult(
			'ls -l',
			array(
				'first line',
				'second line'
			),
			0
		);
	}



	/**
	 *
	 */

	public function testIsSuccess( ) {

		$this->assertTrue( $this->Result->isSuccess( ));
	}



	/**
	 *
	 */

	public function testCommand( ) {

		$this->assertEquals( 'ls -l', $this->Result->command( ));
	}



	/**
	 *
	 */

	public function testOutput( ) {

		$this->assertEquals(
			array(
				'first line',
				'second line'
			),
			$this->Result->output( )
		);
	}



	/**
	 *
	 */

	public function testStatus( ) {

		$this->assertEquals( 0, $this->Result->status( ));
	}
}
