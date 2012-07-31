<?php

/**
 *	A factory that finds the correct Converter to handle documents conversion.
 *
 *	@package Transformist
 *	@author Félix Girault <felix@vtech.fr>
 */

class Transformist_ConverterFactory {

	/**
	 *	A singleton instance of the ConverterFactory.
	 */

	protected static $_instance = null;



	/**
	 *	A list of Converter class names.
	 *
	 *	@var array
	 */

	protected $_converters = array( );



	/**
	 *	Finds a Converter that can convert a document from $sourceMimeType to
	 *	$targetMimeType.
	 *
	 *	@param string $sourceMimeType Mime type of the source document.
	 *	@param string $targetMimeType	Mime type of the target document.
	 */

	public static function load( $sourceMimeType, $targetMimeType ) {

		$_this = self::_instance( );
		$Converter = null;

		foreach ( $_this->_converters as $className ) {
			if (
				$className::convertsFrom( $sourceMimeType ) &&
				$className::convertsTo( $targetMimeType )
			) {
				$Converter = new $className;
				break;
			}
		}

		return $Converter;
	}



	/**
	 *	Returns a singleton instance of the ConverterFactory.
	 *
	 *	@return Transformist_ConverterFactory Instance.
	 */

	protected static function _instance( ) {

		if ( self::$_instance === null ) {
			self::$_instance = new Transformist_ConverterFactory( );
		}

		return self::$_instance;
	}



	/**
	 *	As ConverterFactory is a singleton, this constructor can't be called
	 *	from outside. It is only called once when the singleton instance is
	 *	created, and is in charge of initializing the factory.
	 */

	protected function __construct( ) {

		$this->_listStrategies( );
	}



	/**
	 *	Lists and stores every available Converter. This is useful because it
	 *	avoids to scan file system each time a Converter is requested.
	 */

	protected function _listStrategies( ) {

		$pattern = TRANSFORMIST_ROOT . 'Transformist' . DS . 'Converter' . DS . '*.php';
		$namespace = 'Transformist_Converter_';

		foreach ( glob( $pattern ) as $fileName ) {
			$className = $namespace . basename( $fileName, '.php' );
			$this->_converters[] = $className;
		}
	}
}
