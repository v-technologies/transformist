<?php

/**
 *	A collection of converters.
 *
 *	@package Transformist
 *	@author Félix Girault <felix@vtech.fr>
 */

class Transformist_ConverterCollection {

	/**
	 *	A list of loaded converters.
	 *
	 *	@var array
	 */

	protected $_converters = array( );



	/**
	 *	Constructs the collection.
	 *
	 *	@see Transformist_ConverterCollection::configure( )
	 *	@param array $options Configuration options.
	 */

	public function __construct( ) {

		$this->_listConverters( );
	}



	/**
	 *	Lists available converters.
	 */

	protected function _listConverters( ) {

		$Package = new Transformist_Package( TRANSFORMIST_ROOT );
		$classes = $Package->classes( array( 'Transformist', 'Converter' ), true );

		foreach ( $classes as $className ) {
			if ( class_exists( $className )) {
				$Reflection = new ReflectionClass( $className );

				if ( !$Reflection->isAbstract( )) {
					$this->_converters[ $className ] = null;	// for lazy load
				}
			}
		}
	}



	/**
	 *	Returns the name of all converters.
	 *
	 *	@return array Names.
	 */

	public function names( ) {

		return array_keys( $this->_converters );
	}



	/**
	 *	If necessary, loads the corresponding Converter and returns it.
	 *
	 *	@param string $name A Converter name, as returned by converterNames( ).
	 *	@return Transformist_Converter|null An instance of the requested
	 *		converter, or null if it can't be found.
	 */

	public function get( $name ) {

		if ( !array_key_exists( $name, $this->_converters )) {
			return null;
		}

		$Converter = $this->_converters[ $name ];

		if ( $Converter === null ) {
			$Converter = new $name( );
			$this->_converters[ $name ] = $Converter;
		}

		return $Converter;
	}
}
