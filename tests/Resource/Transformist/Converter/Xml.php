<?php

/**
 *	@author Félix Girault <felix@vtech.fr>
 */

abstract class Transformist_Converter_Xml extends Transformist_Converter {

	/**
	 *	Returns the type of files that the converter accepts.
	 *
	 *	@return array Types.
	 */

	public static function inputTypes( ) {

		return array( 'image/svg+xml', 'text/html' );
	}



	/**
	 *	Returns the type of files that the converter produces.
	 *
	 *	@return string Type.
	 */

	public static function outputType( ) {

		return 'application/xml';
	}



	/**
	 *
	 */

	public function convert( $Document ) {

		file_put_contents(
			$Document->output( )->path( ),
			file_get_contents( $Document->input( )->path( ))
		);
	}
}
