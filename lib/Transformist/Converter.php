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
	 *	Converts the given document.
	 *
	 *	@param Transformist_Document $Document Document to convert.
	 */

	abstract public function convert( $Document );

}
