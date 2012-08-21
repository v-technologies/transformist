<?php

if ( !defined( 'TRANSFORMIST_BOOTSTRAPPED' )) {
	require_once dirname( dirname( __FILE__ ))
		. DIRECTORY_SEPARATOR . 'bootstrap.php';
}

use org\bovigo\vfs\vfsStream;



/**
 *	Test case for Package.
 *
 *	@author Félix Girault <felix@vtech.fr>
 */

class Transformist_PackageTest extends PHPUnit_Framework_TestCase {

	/**
	 *
	 */

	public $vfs = null;



	/**
	 *
	 */

	public $Package = null;



	/**
	 *
	 */

	public function setUp( ) {

		if ( !class_exists( '\\org\\bovigo\\vfs\\vfsStream' )) {
			$this->markTestSkipped( 'vfsStream must be enabled.' );
		}

		$this->vfs = vfsStream::setup(
			'root',
			null,
			array(
				'Class.php' => '',
				'PackageFoo' => array(
					'ClassFoo.php' => '',
					'PackageBar' => array(
						'ClassBar.php' => ''
					)
				)
			)
		);

		$this->Package = new Transformist_Package( vfsStream::url( 'root' ), '_' );
	}



	/**
	 *
	 */

	public function testPath( ) {

		$here = dirname( __FILE__ );

		$Package = new Transformist_Package( $here );
		$this->assertEquals( $here, $Package->path( ));

		$Package = new Transformist_Package( __FILE__ );
		$this->assertEquals( $here, $Package->path( ));
	}



	/**
	 *
	 */

	public function testSeparator( ) {

		$Package = new Transformist_Package( 'foo', '\\' );
		$this->assertEquals( '\\', $Package->separator( ));

		$Package = new Transformist_Package( 'bar', DS );
		$this->assertEquals( DS, $Package->separator( ));
	}



	/**
	 *
	 */

	public function testClasses( ) {

		$this->assertEquals(
			array(
				'Class'
			),
			$this->Package->classes( )
		);
	}



	/**
	 *
	 */

	public function testClassesRecursive( ) {

		$this->assertEquals(
			array(
				'Class',
				'PackageFoo_ClassFoo',
				'PackageFoo_PackageBar_ClassBar'
			),
			$this->Package->classes( array( ), true )
		);
	}



	/**
	 *
	 */

	public function testClassesSubPackage( ) {

		$this->assertEquals(
			array(
				'PackageFoo_ClassFoo'
			),
			$this->Package->classes( array( 'PackageFoo' ))
		);
	}



	/**
	 *
	 */

	public function testClassesSubPackageRecursive( ) {

		$this->assertEquals(
			array(
				'PackageFoo_ClassFoo',
				'PackageFoo_PackageBar_ClassBar'
			),
			$this->Package->classes( array( 'PackageFoo' ), true )
		);
	}
}
