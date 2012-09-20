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
	 *	Returns an array of conversions the converter can handle.
	 *
	 *	array( 'input/type' => 'output/type' )
	 *	array( 'input/type' => array( 'output/type1', 'output/type2' ))
	 *
	 *	@return array Array of supported types.
	 */

	public static function conversions( ) {

		return array( );
	}



	/**
	 *	Converts the given document.
	 *
	 *	@param Transformist_Document $Document Document to convert.
	 */

	abstract public function convert( Transformist_Document $Document );

}
