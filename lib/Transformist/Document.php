<?php

/**
 *	Represents a document to convert.
 *
 *	@package Transformist
 *	@author Félix Girault <felix@vtech.fr>
 */

class Transformist_Document {

	/**
	 *	Input file.
	 *
	 *	@param Transformist_FileInfo
	 */

	protected $_Input;



	/**
	 *	Output file.
	 *
	 *	@param Transformist_FileInfo
	 */

	protected $_Output;



	/**
	 *	Constructs a document given its input and output file infos.
	 *
	 *	@param Transformist_FileInfo $Input Input file info.
	 *	@param Transformist_FileInfo $Output Output file info.
	 */

	public function __construct( $Input, $Output ) {

		$this->_Input = $Input;
		$this->_Output = $Output;
	}



	/**
	 *	Returns the input file info object.
	 *
	 *	@return Transformist_FileInfo File info.
	 */

	public function input( ) {

		return $this->_Input;
	}



	/**
	 *	Returns the output file info object.
	 *
	 *	@return Transformist_FileInfo File info.
	 */

	public function output( ) {

		return $this->_Output;
	}



	/**
	 *	Returns if the document was succesfully converted, i.e. if the output
	 *	file was created.
	 *
	 *	@return boolean True if the document was converted, otherwise false.
	 */

	public function isConverted( ) {

		return $this->_Output->isFile( );
	}
}
