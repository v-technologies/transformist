<?php

/**
 *	A collection of converters.
 *
 *	@package Transformist
 *	@author Félix Girault <felix@vtech.fr>
 */

class Transformist_ConverterCollection {

	/**
	 *	Tells if the collection uses multistep conversions.
	 *
	 *	@see Transformist_ConverterCollection::__construct( )
	 *	@var boolean|integer
	 */

	protected $_multistep = false;



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
	 *	An array of execution error messages.
	 *
	 *	@var array
	 */

	protected $_errors = array( );



	/**
	 *	Constructs the collection, given whether or not to enable multistep
	 *	conversions.
	 *
	 *	For example, consider that the collection contains two converters,
	 *	[text to doc] and [doc to pdf], and that you want to convert a document
	 *	from text to pdf.
	 *
	 *	None of the converters can convert the document directly; but if
	 *	multistep conversions are enabled, the collection will use both
	 *	converters, and convert the document from text to doc, and then from
	 *	doc to pdf, resulting in a conversion from text to pdf.
	 *
	 *	If $multistep is a positive number, then it indicates the maximum number
	 *	of intermediate conversions that can be done to convert a file.
	 *
	 *	@param mixed $multistep Whether or not to enable multistep conversions,
	 *		or a number representing the maximum number of intermediate
	 *		conversions.
	 */

	public function __construct( $multistep = false ) {

		$this->_multistep = $multistep;

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
			$inputs = $Converter->inputTypes( );
			$output = $Converter->outputType( );

			foreach ( $inputs as $input ) {
				if ( !isset( $this->_map[ $input ])) {
					$this->_map[ $input ] = array( );
				}

				$this->_map[ $input ][ $output ] = array( $name );
			}
		}

		if ( $this->_multistep !== false ) {
			$this->_mapConvertersDeeply( );
		}
	}



	/**
	 *	Finds all possible converters combinations to provide a larger panel
	 *	of conversions.
	 */

	protected function _mapConvertersDeeply( ) {

		$limit = intval( $this->_multistep ) + 1;

		do {
			$modified = false;

			foreach ( $this->_map as $input => $outputs ) {
				foreach ( $outputs as $output => $chain ) {
					if ( !isset( $this->_map[ $output ])) {
						continue;
					}

					foreach ( $this->_map[ $output ] as $chainableOutput => $chainableConverters ) {
						if ( isset( $outputs[ $chainableOutput ])) {
							continue;
						}

						$total = count( $chain ) + count( $chainableConverters );

						if (( $this->_multistep === true ) || ( $total <= $limit )) {
							$this->_map[ $input ][ $chainableOutput ] = array_merge(
								$chain,
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

		return $this->_multistep
			? count( $chain )
			: true;
	}



	/**
	 *	Converts the given document.
	 *
	 *	@param Transformist_Document $Document Document to convert.
	 */

	public function convert( $Document ) {

		if ( !$Document->input( )->isReadable( )) {
			throw new Transformist_Exception(
				'The file %s is not readable.',
				$Document->input( )->path( )
			);
		}

		if ( !$Document->output( )->isDirWritable( )) {
			throw new Transformist_Exception(
				'The directory %s is not writable.',
				$Document->output( )->dirPath( )
			);
		}

		$chain = $this->_findChainFor( $Document );
		$result = false;

		switch ( count( $chain )) {
			case 0:
				$result = false;
				break;

			case 1:
				$Converter =& $this->_converters[ array_shift( $chain )];
				$Converter->convert( $Document );

				$result = $Document->isConverted( );
				break;

			default:
				$result = $this->_convertMultistep( $Document, $chain );
				break;
		}

		return $result;
	}



	/**
	 *	Does a multi step conversion of the given document.
	 *
	 *	@param Transformist_Document $Document The document to convert.
	 *	@param array $chain An array of converters name, as returned by
	 *		the _findChainFor( ) method.
	 *	@return boolean True if the document was converted, otherwise false.
	 */

	protected function _convertMultistep( $Document, $chain ) {

		$steps = $this->_makeSteps( $Document, $chain );
		$PreviousStep = null;

		foreach ( $steps as $step ) {
			$Converter = $step['converter'];
			$Document = $step['document'];

			$Converter->convert( $Document );

			// we don't need the temporary file anymore

			if ( $PreviousStep !== null ) {
				unlink( $PreviousStep->output( )->path( ));
			}

			// no need to continue if something gone wrong

			if ( !$Document->isConverted( )) {
				return false;
			}

			$PreviousStep = $Document;
		}

		return true;
	}



	/**
	 *	Splits a documents in multiple documents to facilitate a multistep
	 *	conversion.
	 *
	 *	@param Transformist_Document $Document Document to split.
	 *	@param array $converters An array of converters that will be used to
	 *		convert the given document.
	 *	@return array An array of intermediate documents.
	 */

	protected function _makeSteps( $Document, $chain ) {

		$steps = array( );
		$converterCount = count( $chain );

		for ( $i = 0; $i < $converterCount; $i++ ) {
			$Converter =& $this->_converters[ $chain[ $i ]];

			// first step

			if ( $i === 0 ) {
				$Step = clone $Document;
				$Step->output( )->setType( $Converter->outputType( ));
				$Step->output( )->setExtension( "step-$i" );
			} else {
				$PreviousStep =& $steps[ count( $steps ) - 1 ]['document'];
				$Step = clone $PreviousStep;

				// last step

				if ( $i == ( $converterCount - 1 )) {
					$Step->setInput( $PreviousStep->output( ));
					$Step->setOutput( $Document->output( ));

				// intermediate step

				} else {
					$Step->setInput( $PreviousStep->output( ));
					$Step->output( )->setType( $Converter->outputType( ));
					$Step->output( )->setExtension( "step-$i" );
				}
			}

			$steps[] = array(
				'converter' => $Converter,
				'document' => $Step
			);
		}

		return $steps;
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
			$chain = $this->_map[ $inputType ][ $outputType ];
		}

		return $chain;
	}
}
