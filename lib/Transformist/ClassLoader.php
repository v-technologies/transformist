<?php

/**
 *	A simple PSR-0 compliant class loader.
 *
 *	@package Sae
 *	@author Félix Girault <felix@vtech.fr>
 */

class Transformist_ClassLoader {

	/**
	 *	Base include path for all class files.
	 *
	 *	@var array
	 */

	protected $_basePath = '';



	/**
	 *	Constructor.
	 *
	 *	@param string $basePath Base include path for all class files.
	 */

	public function __construct( $basePath = '' ) {

		$this->_basePath = $basePath;
	}



	/**
	 *	Installs this class loader on the SPL autoload stack.
	 */

	public function register( ) {

		spl_autoload_register( array( $this, 'load' ));
	}



	/**
	 *	Uninstalls this class loader from the SPL autoloader stack.
	 */
	
	public function unregister( ) {

		spl_autoload_unregister( array( $this, 'load' ));
	}



	/**
	 *  Loads the given class or interface.
	 *
	 *  @param string $className name of the class to load
	 */

	public function load( $className ) {

		$path = $this->_basePath . str_replace( '_', DS , $className ) . '.php';

		if ( file_exists( $path )) {
			require_once $path;
		}
	}
}