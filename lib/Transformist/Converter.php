<?php

/**
 *	The base class for a Converter.
 *
 *	@package Transformist
 *	@author Félix Girault <felix@vtech.fr>
 */

abstract class Transformist_Converter {

	/**
	 *	Accepted input type.
	 *
	 *	@var string
	 */

	protected $_inputType = '';



	/**
	 *	Supported output type.
	 *
	 *	@var string
	 */

	protected $_outputType = '';



	/**
	 *	Checks if the Converter can convert the given document.
	 *
	 *	@param Transformist_Document $Document Document to convert.
	 *	@return boolean Whether or not the Converter can convert the document.
	 */

	public function canConvert( $Document ) {

		return (
			$Document->input( )->type( ) == $this->_inputType
			&& $Document->output( )->type( ) == $this->_outputType
		);
	}



	/**
	 *	Returns the type of files that the converter accepts.
	 *
	 *	@return string Type.
	 */

	public function inputType( ) {

		return $this->_inputType;
	}



	/**
	 *	Returns the type of files that the converter produces.
	 *
	 *	@return string Type.
	 */

	public function outputType( ) {

		return $this->_outputType;
	}



	/**
	 *	Ensures that the converter can process the given document, and converts
	 *	it if everything seems fine.
	 *
	 *	@param Transformist_Document $Document Document to convert.
	 *	@throws Transformist_Exception
	 */

	public final function convert( $Document ) {

		if ( !$Document->input( )->isReadable( )) {
			throw new Transformist_Exception(
				'The file `%s` is not readable.',
				$Document->input( )->path( )
			);
		}

		if ( !$Document->output( )->isDirWritable( )) {
			throw new Transformist_Exception(
				'The directory `%s` is not writable.',
				$Document->output( )->dirPath( )
			);
		}

		$this->_convert( $Document );
	}



	/**
	 *	Converts the given document.
	 *
	 *	@param Transformist_Document $Document Document to convert.
	 */

	abstract protected function _convert( $Document );

}
