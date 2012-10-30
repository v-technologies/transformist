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
	 *	A map of converters indexed by their input and output types.
	 *
	 *	@var array
	 */

	protected $_map = array( );



	/**
	 *	Pending conversion settings.
	 *
	 *	@var string
	 */

	protected $_pending = '';



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

	public function __construct( ) {

		$this->_ConverterCollection = new Transformist_ConverterCollection( );
		$this->_mapConverters( );
	}



	/**
	 *	Indexes all converters for their later usage to be easier.
	 */

	protected function _mapConverters( ) {

		$converters = $this->_ConverterCollection->names( );

		foreach ( $converters as $converter ) {
			$conversions = $converter::conversions( );

			foreach ( $conversions as $input => $outputs ) {
				if ( !isset( $this->_map[ $input ])) {
					$this->_map[ $input ] = array( );
				}

				if ( !is_array( $outputs )) {
					$outputs = array( $outputs );
				}

				foreach ( $outputs as $output ) {
					$this->_map[ $input ][ $output ] = $converter;
				}
			}
		}
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

		$converters = $_this->_ConverterCollection->names( );
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

		return ( $this->_converterFor( $Document ) !== null );
	}



	/**
	 *	Sets up some conversions to run later.
	 *
	 *	@param string|array $conversions The input directory, or an array of
	 *		input and output directories, in such form: array( input => output ).
	 *		If no output directory is specified, the converted files will be
	 *		outputted in the input directory.
	 *	@param string|array $from The input pattern, or an array of output types
	 *		indexed by pattern, in such form: array( pattern => outputtype ).
	 *	@param string $to The output type, if $from is a pattern.
	 *	@return Transformist Current instance to allow chaining.
	 */

	public function setup( $dir, $from, $to = '' ) {

		if ( is_array( $dir )) {
			reset( $dir );
			$input = key( $dir );
			$output = current( $dir );
		} else {
			$input = $dir;
			$output = $input;
		}

		$this->_pending = array(
			'input' => Transformist_FileInfo::absolutePath( $input ),
			'output' => Transformist_FileInfo::absolutePath( $output ),
			'conversions' => is_array( $from )
				? $from
				: array( $from => $to )
		);

		return $this;
	}



	/**
	 *	Returns if the given string is a MIME type definition.
	 *
	 *	@param string $string The string to test.
	 *	@return boolean True if the string is a MIME type, otherwise false.
	 */

	protected function _isMimeType( $string ) {

		return preg_match( '#^[-\w]+/[-\w\+]+$#i', $string );
	}



	/**
	 *	Returns if the given string is a glob pattern.
	 *
	 *	@param string $string The string to test.
	 *	@return boolean True if the string is a glob pattern, otherwise false.
	 */

	protected function _isGlobPattern( $string ) {

		if ( strpbrk( $string, '*?[]' ) !== false ) {
			return true;
		}

		return ( strpos( $string, '...' ) !== false );
	}



	/**
	 *	Lists documents based on the settings defined in setup( ).
	 */

	protected function _listDocuments( ) {

		if ( empty( $this->_pending )) {
			return;
		}

		foreach ( $this->_pending['conversions'] as $in => $out ) {
			if ( !$this->_isMimeType( $out )) {
				continue;
			}

			$mime = $this->_isMimeType( $in );

			if ( $mime ) {
				$pattern = '*';
			} else {
				$pattern = $in;
			}

			$path = $this->_pending['input'] . DS . $pattern;
			$files = $this->_isGlobPattern( $pattern )
				? glob( $path, GLOB_NOSORT )
				: array( $path );

			if ( $files ) {
				foreach ( $files as $file ) {
					if ( $mime ) {
						$FileInfo = new Transformist_FileInfo( $file );
						$type = false;

						try {
							$type = $FileInfo->type( );
						} catch ( Transformist_Exception $exception ) {
							//var_dump( $exception->getMessage( ));
						}

						if ( $type !== $in ) {
							continue;
						}
					}

					$Input = new Transformist_FileInfo( $file, ( $mime ? $in : '' ));
					$Output = new Transformist_FileInfo( $this->_pending['output'] . DS . basename( $file ), $out );
					$Output->setExtension( Transformist_Registry::extension( $out ));

					$this->addDocument( new Transformist_Document( $Input, $Output ));
				}
			}
		}
	}



	/**
	 *	Adds the given Document to the conversion queue.
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

	public function run( ) {

		$this->_listDocuments( );
		$success = true;

		foreach ( $this->_documents as $Document ) {
			try {
				$this->_convert( $Document );
			} catch ( Transformist_Exception $exception ) {
				//var_dump( $exception->getMessage( ));
				$success = false;
			}
		}

		$this->_documents = array( );
		return $success;
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

		$Converter = $this->_converterFor( $Document );

		if ( $Converter ) {
			$Converter->convert( $Document );
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

	protected function _converterFor( Transformist_Document $Document ) {

		$inputType = $Document->input( )->type( );
		$outputType = $Document->output( )->type( );
		$Converter = null;

		if ( isset( $this->_map[ $inputType ][ $outputType ])) {
			$Converter = $this->_ConverterCollection->get(
				$this->_map[ $inputType ][ $outputType ]
			);
		}

		return $Converter;
	}
}
