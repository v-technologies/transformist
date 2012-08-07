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
	 *	A list of Converter class names.
	 *
	 *	@var array
	 */

	protected $_converters = array( );



	/**
	 *	Finds a Converter that can convert the given document.
	 *
	 *	@param Transformist_Document $Document Document to convert.
	 *	@return mixed A converter if one matches the request, otherwise null.
	 */

	public static function load( $Document ) {

		$_this = self::_instance( );
		$Converter = null;

		foreach ( $_this->_converters as $className ) {
			if ( $className::canConvert( $Document )) {
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

		$this->_listConverters( );
	}



	/**
	 *	Lists and stores every available Converter. This is useful to avoid
	 *	scanning file system each time a Converter is requested.
	 */

	protected function _listConverters( ) {

		$files = glob( TRANSFORMIST_ROOT . 'Transformist' . DS . 'Converter' . DS . '*.php' );

		foreach ( $files as $fileName ) {
			$className = 'Transformist_Converter_' . basename( $fileName, '.php' );

			if (
				class_exists( $className )
				&& is_subclass_of( $className, 'Transformist_Converter' )
			) {
				$this->_converters[] = $className;
			}
		}
	}
}
