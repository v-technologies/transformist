<?php

if ( !defined( 'INCLUDED' )) {
	require_once dirname( dirname( __FILE__ )) . DIRECTORY_SEPARATOR . 'bootstrap.php';
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

	public $vfsStructure = array(
		'Class.php' => '',
		'PackageFoo' => array(
			'ClassFoo.php' => '',
			'PackageBar' => array(
				'ClassBar.php' => ''
			)
		)
	);



	/**
	 *
	 */

	public $vfs = null;



	/**
	 *
	 */

	public function setUp( ) {

		$this->vfs = vfsStream::setup( 'root', null, $this->vfsStructure );
	}



	/**
	 *
	 */

	public function testPath( ) {

		$here = dirname( __FILE__ );

		$Package = new Transformist_Package( $here );
		$this->assertEquals( $here, $Package->path( ));

		$Package->setPath( __FILE__ );
		$this->assertEquals( $here, $Package->path( ));
	}



	/**
	 *
	 */

	public function testSeparator( ) {

		$Package = new Transformist_Package( 'foo', '\\' );
		$this->assertEquals( '\\', $Package->separator( ));

		$Package->setSeparator( DS );
		$this->assertEquals( DS, $Package->separator( ));
	}



	/**
	 *
	 */

	public function testClasses( ) {

		$Package = new Transformist_Package( vfsStream::url( 'root' ), '_' );

		$this->assertEquals(
			array(
				'Class'
			),
			$Package->classes( )
		);

		$this->assertEquals(
			array(
				'Class',
				'PackageFoo_ClassFoo',
				'PackageFoo_PackageBar_ClassBar'
			),
			$Package->classes( array( ), true )
		);

		$this->assertEquals(
			array(
				'PackageFoo_ClassFoo'
			),
			$Package->classes( array( 'PackageFoo' ))
		);

		$this->assertEquals(
			array(
				'PackageFoo_ClassFoo',
				'PackageFoo_PackageBar_ClassBar'
			),
			$Package->classes( array( 'PackageFoo' ), true )
		);
	}
}
