<?php

/**
 *	The base class for a Converter.
 *
 *	@package Transformist
 *	@author Félix Girault <felix@vtech.fr>
 */

abstract class Transformist_Converter {

	/**
	 *	Runs some tests to determine if the converter can run properly.
	 *	For example, checks if an external software is installed on the system.
	 *
	 *	@return boolean True if everything went good, otherwise false.
	 */

	public static function isRunnable( ) {

		return true;
	}



	/**
	 *	Returns the type of files that the converter accepts.
	 *
	 *	@return array Types.
	 */

	public static function inputTypes( ) {

		return array( );
	}



	/**
	 *	Returns the type of files that the converter produces.
	 *
	 *	@return string Type.
	 */

	public static function outputType( ) {

		return '';
	}



	/**
	 *	Converts the given document.
	 *
	 *	@param Transformist_Document $Document Document to convert.
	 */

	abstract public function convert( Transformist_Document $Document );

}
