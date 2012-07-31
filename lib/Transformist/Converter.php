<?php

/**
 *	@package Transformist
 *	@author Félix Girault <felix@vtech.fr>
 */

class Transformist_Converter {

	/**
	 *	Checks if the Converter can convert files from the given format.
	 *
	 *	@param string $mimeType Mime type to test.
	 *	@return boolean Whether or not the Converter can handle the mime type.
	 */

	public static function convertsFrom( $mimeType ) {

		return false;
	}



	/**
	 *	Checks if the Converter can convert files to the given format.
	 *
	 *	@param string $mimeType Mime type to test.
	 *	@return boolean Whether or not the Converter can handle the mime type.
	 */

	public static function convertsTo( $mimeType ) {

		return false;
	}



	/**
	 *	Converts the given document.
	 *
	 *	@param string $document The document to convert.
	 *	@return mixed The converted document, or false if an error occurs.
	 */

	public function convert( $document ) {

		return false;
	}
}
