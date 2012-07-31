<?php

require_once( dirname( dirname( __FILE__ )) . DIRECTORY_SEPARATOR . 'bootstrap.php' );



/**
 *	Test case for Transformist.
 */

class Transformist_TransformistTest extends PHPUnit_Framework_TestCase {

	/**
	 *
	 */

	public function testConstruct( ) {

		$Transformist = new Transformist_Transformist( '' );
		$this->assertTrue( $Transformist instanceof Transformist_Transformist );

		$Transformist = new Transformist_Transformist( '' );
	}
}
