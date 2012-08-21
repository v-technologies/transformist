<?php

/**
 *	The base class for a Converter.
 *
 *	@package Transformist
 *	@author Félix Girault <felix@vtech.fr>
 */

abstract class Transformist_Converter {

	/**
	 *	Accepted input types.
	 *
	 *	@var array
	 */

	protected $_inputTypes = array( );



	/**
	 *	Supported output type.
	 *
	 *	@var string
	 */

	protected $_outputType = '';



	/**
	 *	Runs some tests to determine if the converter can run properly.
	 *	For example, checks if an external software is installed on the system.
	 *
	 *	@return boolean True if everything went good, otherwise false.
	 */

	public function isRunnable( ) {

		return true;
	}



	/**
	 *	Checks if the Converter can convert the given document.
	 *
	 *	@param Transformist_Document $Document Document to convert.
	 *	@return boolean Whether or not the Converter can convert the document.
	 */

	public function canConvert( $Document ) {

		return (
			in_array( $Document->input( )->type( ), $this->_inputTypes )
			&& $Document->output( )->type( ) == $this->_outputType
		);
	}



	/**
	 *	Returns the type of files that the converter accepts.
	 *
	 *	@return array Types.
	 */

	public function inputTypes( ) {

		return $this->_inputTypes;
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
	 *	Converts the given document.
	 *
	 *	@param Transformist_Document $Document Document to convert.
	 */

	abstract public function convert( $Document );

}
