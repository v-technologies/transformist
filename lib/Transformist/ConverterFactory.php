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
	 *
	 *	@var Transformist_ConverterFactory
	 */

	protected static $_instance = null;



	/**
	 *	The path in which Converters can be found.
	 *
	 *	@var string
	 */

	protected $_path = '';	// initialized in constructor



	/**
	 *	The package of Converters.
	 *
	 *	@var string
	 */

	protected $_package = 'Transformist_Converter_';



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
			self::$_instance = new self( );
		}

		return self::$_instance;
	}



	/**
	 *	As ConverterFactory is a singleton, this constructor can't be called
	 *	from outside. It is only called once when the singleton instance is
	 *	created, and is in charge of initializing the factory.
	 */

	protected function __construct( ) {

		$this->_path = TRANSFORMIST_ROOT . 'Transformist' . DS . 'Converter' . DS;
		$this->_listConverters( );
	}



	/**
	 *	Lists and stores every available Converter. This is useful to avoid
	 *	scanning file system each time a Converter is requested.
	 */

	protected function _listConverters( ) {

		$files = glob( $this->_path . '*.php' );

		foreach ( $files as $fileName ) {
			$className = $this->_package . basename( $fileName, '.php' );

			if ( class_exists( $className )) {
				$this->_converters[] = $className;
			}
		}
	}
}
