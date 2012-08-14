<?php

/**
 *	A collection of converters.
 *
 *	@package Transformist
 *	@author Félix Girault <felix@vtech.fr>
 */

class Transformist_ConverterCollection {

	/**
	 *	Tells if the collection uses deep conversions.
	 *
	 *	@see Transformist_ConverterCollection::__construct( )
	 *	@var boolean|integer
	 */

	protected $_deep = false;



	/**
	 *	A list of loaded converters.
	 *
	 *	@var array
	 */

	protected $_converters = array( );



	/**
	 *	A map of converters indexed by their input and output types.
	 *
	 *	@var array
	 */

	protected $_map = array( );



	/**
	 *	Constructs the collection, given whether or not to enable deep conversions.
	 *
	 *	For example, consider that the collection contains two converters,
	 *	[text to doc] and [doc to pdf], and that you want to convert a document
	 *	from text to pdf.
	 *
	 *	None of the converters can convert the document directly; but if $deep
	 *	is set to true, the collection will use both converters, and convert
	 *	the document from text to doc, and then from doc to pdf, resulting in
	 *	a conversion from text to pdf.
	 *
	 *	If $deep is a positive number, then it indicates the maximum number of
	 *	intermediate conversions that can be done to convert a file.
	 *
	 *	@param mixed $deep Whether or not to enable deep conversions, or a
	 *		number representing the maximum number of intermediate conversions.
	 */

	public function __construct( $deep = false ) {

		$this->_deep = $deep;

		$this->_loadConverters( );
		$this->_mapConverters( );
	}



	/**
	 *	Lists and loads available converters.
	 */

	protected function _loadConverters( ) {

		$Package = new Transformist_Package( TRANSFORMIST_ROOT );
		$classes = $Package->classes( array( 'Transformist', 'Converter' ), true );

		foreach ( $classes as $className ) {
			if ( class_exists( $className )) {
				$Reflection = new ReflectionClass( $className );

				if ( !$Reflection->isAbstract( )) {
					$this->_converters[ $className ] = new $className( );
				}
			}
		}
	}



	/**
	 *	Indexes all converters for their later usage to be easier.
	 */

	protected function _mapConverters( ) {

		foreach ( $this->_converters as $name => $Converter ) {
			$input = $Converter->inputType( );
			$output = $Converter->outputType( );

			if ( !isset( $this->_map[ $input ])) {
				$this->_map[ $input ] = array( );
			}

			if ( isset( $this->_map[ $input ][ $output ])) {
				trigger_error(
					sprintf(
						'Two converters found for conversions from `%s` to `%s`. ' .
						'Using `%s` instead of `%s`.',
						$Converter->inputType( ),
						$Converter->outputType( ),
						$name,
						array_shift( $this->_map[ $input ][ $output ])
					),
					E_USER_NOTICE
				);
			}

			$this->_map[ $input ][ $output ] = array( $name );
		}

		if ( $this->_deep !== false ) {
			$this->_mapConvertersDeeply( );
		}
	}



	/**
	 *	Finds all possible converters combinations to provide a larger panel
	 *	of possible conversions.
	 */

	protected function _mapConvertersDeeply( ) {

		$limit = intval( $this->_deep ) + 1;

		do {
			$modified = false;

			foreach ( $this->_map as $input => $outputs ) {
				foreach ( $outputs as $output => $converters ) {
					if ( !isset( $this->_map[ $output ])) {
						continue;
					}

					foreach ( $this->_map[ $output ] as $chainableOutput => $chainableConverters ) {
						if ( isset( $outputs[ $chainableOutput ])) {
							continue;
						}

						$total = count( $converters ) + count( $chainableConverters );

						if (( $this->_deep === true ) || ( $total <= $limit )) {
							$this->_map[ $input ][ $chainableOutput ] = array_merge(
								$converters,
								$chainableConverters
							);

							$modified = true;
						}
					}
				}
			}
		} while ( $modified );
	}



	/**
	 *	Returns an array of all available conversions.
	 *
	 *	@param array Available conversions.
	 */

	public function availableConversions( ) {

		$conversions = array( );

		foreach ( $this->_map as $input => $outputs ) {
			$conversions[ $input ] = array_keys( $outputs );
		}

		return $conversions;
	}



	/**
	 *	Checks if the collection knows a way convert the given document.
	 *
	 *	@param Transformist_Document $Document Document to convert.
	 *	@return boolean|integer True if the document can be converter, otherwise
	 *		false. If deep conversions are enabled, the method will return
	 *		the number of conversions that will be done to achieve the full
	 *		conversion.
	 */

	public function canConvert( $Document ) {

		$chain = $this->_findChainFor( $Document );

		if ( empty( $chain )) {
			return false;
		}

		return $this->_deep
			? count( $chain )
			: true;
	}



	/**
	 *	Converts the given document.
	 *
	 *	@param Transformist_Document $Document Document to convert.
	 */

	public function convert( $Document ) {

		$chain = $this->_findChainFor( $Document );

		if ( empty( $chain )) {
			return false;
		}

		// Simple case, only one Converter is required to do the job

		if ( count( $chain ) == 1 ) {
			$Converter =& $this->_converters[ array_shift( $chain )];
			$Converter->convert( $Document );

		// Multistep conversion

		} else {
			foreach ( $chain as $converterName ) {
				$Converter = $this->_converters[ $converterName ];
			}
		}
	}



	/**
	 *	Finds and returns a chain of converters which can convert the given
	 *	document.
	 *
	 *	@param Transformist_Document $Document Document to convert.
	 *	@return array An array of converter names, or an empty array if no
	 *		chain were found.
	 */

	protected function _findChainFor( $Document ) {

		$inputType = $Document->input( )->type( );
		$outputType = $Document->output( )->type( );
		$chain = array( );

		if ( isset( $this->_map[ $inputType ][ $outputType ])) {
			$this->_map[ $inputType ][ $outputType ];
		}

		return $chain;
	}
}
