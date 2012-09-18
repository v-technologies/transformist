<?php

if ( !defined( 'TRANSFORMIST_BOOTSTRAPPED' )) {
	require_once dirname( dirname( __FILE__ ))
		. DIRECTORY_SEPARATOR . 'bootstrap.php';
}



/**
 *	Test case for Registry.
 *
 *	@author Félix Girault <felix@vtech.fr>
 */

class Transformist_RegistryTest extends PHPUnit_Framework_TestCase {

	/**
	 *
	 */

	public function testUnregisteredExtension( ) {

		$this->assertEmpty( Transformist_Registry::extension( 'mime/type' ));
	}



	/**
	 *
	 */

	public function testExtension( ) {

		Transformist_Registry::register( 'ext', 'mime/type' );

		$this->assertEquals( 'ext', Transformist_Registry::extension( 'mime/type' ));
	}



	/**
	 *
	 */

	public function testRegisterMulti( ) {

		Transformist_Registry::register(
			array(
				'foo' => 'mime/foo',
				'bar' => 'mime/bar'
			)
		);

		$this->assertEquals( 'foo', Transformist_Registry::extension( 'mime/foo' ));
		$this->assertEquals( 'bar', Transformist_Registry::extension( 'mime/bar' ));
	}
}
