<?php

/**
 *	A high level API to handle file conversions.
 *
 *	@author Félix Girault <felix@vtech.fr>
 */

class Transformist {

	/**
	 *	A collection of converters.
	 *
	 *	@var Transformist_ConverterCollection
	 */

	protected $_ConverterCollection = null;



	/**
	 *	Default configuration options.
	 *
	 *	@var array
	 */

	protected $_defaults = array(
		'multistep' => false
	);



	/**
	 *	Tells if the collection uses multistep conversions.
	 *
	 *	@see Transformist_ConverterCollection::enableMultistep( )
	 *	@var boolean|integer
	 */

	protected $_multistep = -1;



	/**
	 *	A map of converters indexed by their input and output types.
	 *
	 *	@var array
	 */

	protected $_map = array( );



	/**
	 *	Pending input files, appended by from( ) and waiting for to( ).
	 *
	 *	@var array
	 */

	protected $_pendingInputs = array( );



	/**
	 *	Pending documents to convert.
	 *
	 *	@var array
	 */

	protected $_documents = array( );



	/**
	 *	An array of execution error messages.
	 *
	 *	@var array
	 */

	protected $_errors = array( );



	/**
	 *	Constructs Transformist, given an array of configuration options.
	 *	These options will be merged with Transformist::$_defaults.
	 *
	 *	@see Transformist::configure( )
	 *	@param array $options Configuration options.
	 */

	public function __construct( array $options = array( )) {

		$this->_ConverterCollection = new Transformist_ConverterCollection( );

		$this->configure( array_merge( $this->_defaults, $options ));
	}



	/**
	 *	Configures the collection.
	 *
	 *	### Options
	 *
	 *	- multistep - See Transformist::_setMultistep( ).
	 *
	 *	@param array|string $key Either a key for $value, or an array of
	 *		key => value configuration options.
	 *	@param mixed $value If $key is a string, the value for this key.
	 *		$value will be skipped if an array of configuration options is
	 *		passed as first parameter.
	 */

	public function configure( $key, $value = null ) {

		$options = is_array( $key )
			? $key
			: array( $key => $value );

		foreach ( $options as $key => $value ) {
			switch ( $key ) {
				case 'multistep':
					if ( is_bool( $value ) || is_int( $value )) {
						$this->_setMultistep( $value );
					}
					break;
			}
		}
	}



	/**
	 *	Enables or disables multistep conversions.
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

	protected function _setMultistep( $multistep ) {

		if ( $multistep === $this->_multistep ) {
			return;
		}

		$this->_multistep = $multistep;
		$this->_map = array( );
		$this->_mapConverters( );

		if ( $this->_multistep ) {
			$this->_mapConvertersDeeply( );
		}
	}



	/**
	 *	Indexes all converters for their later usage to be easier.
	 */

	protected function _mapConverters( ) {

		$converters = $this->_ConverterCollection->converterNames( );

		foreach ( $converters as $name ) {
			$inputs = $name::inputTypes( );
			$output = $name::outputType( );

			foreach ( $inputs as $input ) {
				if ( !isset( $this->_map[ $input ])) {
					$this->_map[ $input ] = array( );
				}

				$this->_map[ $input ][ $output ] = array( $name );
			}
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
						if ( isset( $outputs[ $chainableOutput ]) || ( $input == $chainableOutput )) {
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
	 *	Runs a test on every converter and returns the results of these tests.
	 *	Can be called statically too.
	 *
	 *	@return array Test results, boolean values indexed by converters name.
	 */

	public function testConverters( ) {

		$_this = isset( $this )
			? $this
			: new self( );

		$converters = $_this->_ConverterCollection->converterNames( );
		$results = array( );

		foreach ( $converters as $converter ) {
			$results[ $converter ] = $converter::isRunnable( );
		}

		return $results;
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
	 *	Checks if there is a way convert the given document.
	 *
	 *	@param Transformist_Document $Document Document to convert.
	 *	@return boolean|integer True if the document can be converter, otherwise
	 *		false. If deep conversions are enabled, the method will return
	 *		the number of conversions that will be done to achieve the full
	 *		conversion.
	 */

	public function canConvert( Transformist_Document $Document ) {

		$chain = $this->_findChainFor( $Document );

		if ( empty( $chain )) {
			return false;
		}

		return $this->_multistep
			? count( $chain )
			: true;
	}



	/**
	 *	Sets the input file infos for later conversion.
	 *
	 *	@param string $filePath Path to the input file.
	 *	@param string $type MIME type of the file to avoid auto detection.
	 *	@return Transformist Current instance to allow chaining.
	 */

	public function from( $filePath, $type = '' ) {

		$this->_pendingInputs[] = new Transformist_FileInfo( $filePath, $type );
		return $this;
	}



	/**
	 *	Sets the output file info for all the pending inputs.
	 *
	 *	@param string $filePath Path to the output file.
	 *	@param string $type MIME type of the file.
	 *	@return Transformist Current instance to allow chaining.
	 */

	public function to( $filePath, $type ) {

		$Output = new Transformist_FileInfo( $filePath, $type );

		foreach ( $this->_pendingInputs as $Input ) {
			$this->addDocument( new Transformist_Document( $Input, $Output ));
		}

		$this->_pendingInputs = array( );
		return $this;
	}



	/**
	 *	Adds a Document to the conversion queue.
	 *
	 *	@param Transformist_Document $Document Document to add.
	 *	@return Transformist Current instance to allow chaining.
	 */

	public function addDocument( Transformist_Document $Document ) {

		$this->_documents[] = $Document;
		return $this;
	}



	/**
	 *	Converts all pending documents.
	 *
	 *	@param Transformist_Document $Document Document to convert.
	 *	@return boolean True if every document was converted, otherwise false.
	 */

	public function convert( ) {

		$succes = true;

		foreach ( $this->_documents as $Document ) {
			try {
				$this->_convert( $Document );
			} catch ( Transformist_Exception $exception ) {
				// log
			}

			if ( !$Document->isConverted( )) {
				$succes = false;
			}
		}

		$this->_documents = array( );
		return $succes;
	}



	/**
	 *	Converts the given document.
	 *
	 *	@param Transformist_Document $Document Document to convert.
	 */

	protected function _convert( Transformist_Document $Document ) {

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

		switch ( count( $chain )) {
			case 0:
				break;

			case 1:
				$Converter = $this->_ConverterCollection->converter( array_shift( $chain ));
				$Converter->convert( $Document );
				break;

			default:
				$this->_convertMultistep( $Document, $chain );
				break;
		}
	}



	/**
	 *	Does a multi step conversion of the given document.
	 *
	 *	@param Transformist_Document $Document The document to convert.
	 *	@param array $chain An array of converters name, as returned by
	 *		the _findChainFor( ) method.
	 *	@return boolean True if the document was converted, otherwise false.
	 */

	protected function _convertMultistep( Transformist_Document $Document, $chain ) {

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

	protected function _makeSteps( Transformist_Document $Document, $chain ) {

		$steps = array( );
		$converterCount = count( $chain );

		for ( $i = 0; $i < $converterCount; $i++ ) {
			$Converter = $this->_ConverterCollection->converter( $chain[ $i ]);

			// first step

			if ( $i === 0 ) {
				$Step = clone $Document;
				$Step->output( )->setType( $Converter::outputType( ));
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
					$Step->output( )->setType( $Converter::outputType( ));
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

	protected function _findChainFor( Transformist_Document $Document ) {

		$inputType = $Document->input( )->type( );
		$outputType = $Document->output( )->type( );
		$chain = array( );

		if ( isset( $this->_map[ $inputType ][ $outputType ])) {
			$chain = $this->_map[ $inputType ][ $outputType ];
		}

		return $chain;
	}
}
