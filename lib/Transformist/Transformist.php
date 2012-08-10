<?php

/**
 *	A high level API to handle file conversions.
 *
 *	@package Transformist
 *	@author Félix Girault <felix@vtech.fr>
 */

class Transformist_Transformist {

	/**
	 *	A collection of converters.
	 *
	 *	@var Transformist_ConverterCollection
	 */

	protected $_ConverterCollection = null;



	/**
	 *	Returns an array of all available conversions.
	 *
	 *	@param array Available conversions.
	 */

	public static function availableConversions( ) {

		$_this = self::_instance( );
		return $_this->_ConverterCollection->availableConversions( );
	}



	/**
	 *	Converts the document to a format matching the given mime type.
	 *
	 *	@param Transformist_Document $Document The document to convert.
	 *	@return mixed The path of the converted document, or false if the
	 *		document could not be converted.
	 */

	public static function convert( $Document ) {

		$_this = self::_instance( );
		$_this->_ConverterCollection->convert( $Document );
	}



	/**
	 *	Returns a singleton instance of the object.
	 *
	 *	@return Transformist_Transformist Instance.
	 */

	protected static function _instance( ) {

		static $Instance = null;

		if ( $Instance === null ) {
			$Instance = new self( );
		}

		return $Instance;
	}



	/**
	 *	As Transformist is a singleton, this constructor can't be called
	 *	from outside. It is only called once when the singleton instance is
	 *	created, and is in charge of initializing the object.
	 */

	protected function __construct( ) {

		$this->_ConverterCollection = new Transformist_ConverterCollection( );
	}
}
