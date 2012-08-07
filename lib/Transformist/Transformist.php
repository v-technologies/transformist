<?php

/**
 *	A high level API to handle file conversions.
 *
 *	@package Transformist
 *	@author Félix Girault <felix@vtech.fr>
 */

class Transformist_Transformist {

	/**
	 *	Converts the document to a format matching the given mime type.
	 *
	 *	@param Transformist_Document $Document The document to convert.
	 *	@return mixed The path of the converted document, or false if the
	 *		document could not be converted.
	 */

	public static function convert( $Document ) {

		$Converter = Transformist_ConverterFactory::load( $Document );

		if ( $Converter !== null ) {
			$Converter->convert( $Document );
		}
	}
}
