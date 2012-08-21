<?php

/**
 *	A high level API to handle file conversions.
 *
 *	@author Félix Girault <felix@vtech.fr>
 */

class Transformist {

	/**
	 *	Singleton instance.
	 *
	 *	@var Transformist
	 */

	protected static $_Instance = null;



	/**
	 *	A collection of converters.
	 *
	 *	@var Transformist_ConverterCollection
	 */

	protected $_ConverterCollection = null;



	/**
	 *	An array of execution error messages.
	 *
	 *	@var array
	 */

	protected $_errors = array( );



	/**
	 *	Configures Transformist.
	 *
	 *	### Options
	 *
	 *	- multistep - See Transformist_ConverterCollection::enableMultistep( );
	 *
	 *	@param array $options An array of configuration options.
	 */

	public static function configure( $options ) {

		if ( isset( $options['multistep'])) {
			$_this = self::_instance( );
			$_this->_ConverterCollection->enableMultistep( $options['multistep']);
		}
	}



	/**
	 *	Runs a test on every converter and returns the results of these tests.
	 *
	 *	@return array Test results, boolean values indexed by converters name.
	 */

	public static function testConverters( ) {

		$_this = self::_instance( );
		return $_this->_ConverterCollection->testConverters( );
	}



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
	 *	Sets the input file infos for later conversion.
	 *
	 *	@param string $filePath Path to the input file.
	 *	@param string $type MIME type of the file to avoid auto detection.
	 */

	public static function convert( $filePath, $type = '' ) {

		$_this = self::_instance( );
		$_this->_Input = new Transformist_FileInfo( $filePath, $type );

		return $_this;
	}



	/**
	 *	Sets the output file info and start the conversion.
	 *
	 *	@param string $filePath Path to the output file.
	 *	@param string $type MIME type of the file.
	 */

	public function to( $filePath, $type ) {

		$Output = new Transformist_FileInfo( $filePath, $type );
		$result = false;

		try {
			$result = $this->_ConverterCollection->convert(
				new Transformist_Document( $this->_Input, $Output )
			);
		} catch ( Transformist_Exception $e ) {
			//
		}

		return $result;
	}



	/**
	 *	Returns a singleton instance of the object.
	 *
	 *	@return Transformist_Transformist Instance.
	 */

	protected static function _instance( ) {

		if ( self::$_Instance === null ) {
			self::$_Instance = new self( );
		}

		return self::$_Instance;
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
