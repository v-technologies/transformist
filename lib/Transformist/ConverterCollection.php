<?php

/**
 *	A collection of converters.
 *
 *	@package Transformist
 *	@author Félix Girault <felix@vtech.fr>
 */

class Transformist_ConverterCollection {

	/**
	 *	Tells whether or not to enable deep conversions.
	 *	For example, consider that the collection contains two converters,
	 *	[text to doc] and [doc to pdf], and that you want to convert a document
	 *	from text to pdf.
	 *	None of the converters can convert the document directly; but if $_deep
	 *	is set to true, the collection will use both converters, and convert
	 *	the document from text to doc, and then from doc to pdf, resulting in
	 *	a conversion from text to pdf.
	 *	If $_deep is a positive number, then it indicates the maximum number of
	 *	intermediate conversions that can be done to convert a file.
	 *
	 *	@var boolean|integer
	 */

	protected $_deep = false;



	/**
	 *	A list of converters.
	 *
	 *	@var array
	 */

	protected $_converters = array( );



	/**
	 *
	 */

	protected $_map = array( );



	/**
	 *
	 */

	public function __construct( $deep = false ) {

		$this->_deep = $deep;

		$this->_loadConverters( );
		$this->_compile( );
	}



	/**
	 *	Compiles and returns every possible conversions.
	 */

	public function availableConversions( ) {

		$conversions = array( );

		foreach ( $this->_map as $input => $outputs ) {
			$conversions[ $input ] = array_keys( $outputs );
		}

		return $conversions;
	}



	/**
	 *	Finds a Converter that can convert the given document.
	 *
	 *	@param Transformist_Document $Document Document to convert.
	 *	@return mixed A converter if one matches the request, otherwise null.
	 */

	public function convert( $Document ) {

		$Converter = null;

		foreach ( $this->_converters as $className ) {
			if ( $className::canConvert( $Document )) {
				$Converter = new $className;
				break;
			}
		}

		if ( $Converter === null ) {
			//$Converter
		}

		return $Converter;
	}



	/**
	 *	Lists and loads available converters.
	 */

	protected function _loadConverters( ) {

		$files = glob( TRANSFORMIST_ROOT . 'Transformist' . DS . 'Converter' . DS . '*.php' );

		foreach ( $files as $fileName ) {
			$className = 'Transformist_Converter_' . basename( $fileName, '.php' );

			if (
				class_exists( $className )
				&& is_subclass_of( $className, 'Transformist_Converter' )
			) {
				$this->_converters[] = new $className( );
			}
		}
	}



	/**
	 *
	 */

	protected function _compile( ) {

		$map = array( );

		foreach ( $this->_converters as &$Converter ) {
			$conversions = $Converter->availableConversions( );

			foreach ( $conversions as $input => $outputs ) {
				if ( !isset( $map[ $input ])) {
					$map[ $input ] = array( );
				}

				foreach (( array )$outputs as $output ) {
					$map[ $input ][ $output ] = array( &$Converter );
				}
			}
		}

		if ( $this->_deep !== false ) {
			do {
				$modified = false;

				foreach ( $map as $input => $outputs ) {
					foreach ( $outputs as $output => $converters ) {
						if ( isset( $map[ $output ])) {
							foreach ( $map[ $output ] as $chainableOutput => $chainableConverters ) {
								if ( !isset( $outputs[ $chainableOutput ])) {
									$path = array_merge( $converters, $chainableConverters );
									$merge = $this->_deep;

									if (( $merge !== true ) && ( count( $path ) > ( $merge + 1 ))) {
										$merge = false;
									}

									if ( $merge ) {
										$map[ $input ][ $output ] = $path;
										$modified = true;
									}
								}
							}
						}
					}
				}
			} while ( $modified );
		}

		$this->_map = $map;
	}
}
